<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * タスク(Task)を JSON で操作する REST API。
 *
 * すべて /api/tasks 以下のエンドポイント。PersonApiController と同じ構成で、
 * ステートレス・認証なし・CSRF 不要。
 */
class TaskApiController extends Controller
{
    /**
     * 一覧取得  GET /api/tasks
     *
     * 新しい順で返す。
     */
    public function index(): JsonResponse
    {
        $tasks = Task::orderByDesc('id')->get();

        return response()->json([
            'data'  => $tasks,
            'count' => $tasks->count(),
        ]);
    }

    /**
     * 1件取得  GET /api/tasks/{task}
     */
    public function show(Task $task): JsonResponse
    {
        return response()->json(['data' => $task]);
    }

    /**
     * 新規作成  POST /api/tasks
     *
     * バリデーション失敗時は Laravel が自動で 422 + エラー JSON を返す。
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $task = Task::create($validated);

        return response()->json(['data' => $task], 201);
    }

    /**
     * 更新  PUT/PATCH /api/tasks/{task}
     */
    public function update(Request $request, Task $task): JsonResponse
    {
        $validated = $request->validate([
            'title'       => ['sometimes', 'required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $task->update($validated);

        return response()->json(['data' => $task]);
    }

    /**
     * 削除  DELETE /api/tasks/{task}
     */
    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
