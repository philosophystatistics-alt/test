<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 人(Person)を JSON で操作する REST API。
 *
 * すべて /api/people 以下のエンドポイント。HTML ではなく JSON を返すため、
 * ブラウザの fetch / axios や curl / Postman から叩いて学習する用途に使う。
 */
class PersonApiController extends Controller
{
    /**
     * 一覧取得  GET /api/people
     */
    public function index(): JsonResponse
    {
        $people = Person::orderBy('id')->get();

        return response()->json([
            'data'  => $people,
            'count' => $people->count(),
        ]);
    }

    /**
     * 1件取得  GET /api/people/{person}
     *
     * ルートモデルバインディングで該当 ID が無ければ Laravel が自動で 404 を返す。
     */
    public function show(Person $person): JsonResponse
    {
        return response()->json(['data' => $person]);
    }

    /**
     * 新規作成  POST /api/people
     *
     * バリデーション失敗時は Laravel が自動で 422 + エラー JSON を返す。
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'role' => ['nullable', 'string', 'max:50'],
        ]);

        $person = Person::create($validated);

        // 作成成功は 201 Created
        return response()->json(['data' => $person], 201);
    }

    /**
     * 更新  PUT/PATCH /api/people/{person}
     */
    public function update(Request $request, Person $person): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:50'],
            'role' => ['nullable', 'string', 'max:50'],
        ]);

        $person->update($validated);

        return response()->json(['data' => $person]);
    }

    /**
     * 削除  DELETE /api/people/{person}
     */
    public function destroy(Person $person): JsonResponse
    {
        $person->delete();

        // 本文なしの 204 No Content
        return response()->json(null, 204);
    }
}
