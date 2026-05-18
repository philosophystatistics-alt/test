<?php

namespace App\Http\Controllers;

use App\Models\Greeting;
use App\Models\Person;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GreetingController extends Controller
{
    /**
     * greetings テーブルの一覧を表示する。
     */
    public function index(): View
    {
        // 紐づく人(person)もまとめて取得し N+1 を回避。新しい順に並べる。
        $greetings = Greeting::with('person')
            ->latest()
            ->get();

        // 追加フォームの選択肢用に人の一覧も渡す。
        $people = Person::orderBy('name')->get();

        // 人ごとの挨拶数を集計（多い順）。
        $countsByPerson = $greetings
            ->groupBy(fn (Greeting $g) => $g->person?->name ?? '（不明）')
            ->map->count()
            ->sortDesc();

        // サマリー用のカウント。
        $stats = [
            'total'        => $greetings->count(),
            'people'       => $countsByPerson->count(),
            'maxPerPerson' => $countsByPerson->max() ?? 0,
        ];

        return view('greetings.index', [
            'greetings'      => $greetings,
            'people'         => $people,
            'countsByPerson' => $countsByPerson,
            'stats'          => $stats,
        ]);
    }

    /**
     * 挨拶を1件追加する。
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'person_id' => ['required', 'exists:people,id'],
            'message'   => ['required', 'string', 'max:255'],
        ], [
            'person_id.required' => '人を選択してください。',
            'person_id.exists'   => '選択された人が存在しません。',
            'message.required'   => '挨拶メッセージを入力してください。',
            'message.max'        => '挨拶は255文字以内で入力してください。',
        ]);

        Greeting::create($validated);

        return redirect()
            ->route('greetings.index')
            ->with('status', '挨拶を追加しました。');
    }

    /**
     * 挨拶を1件削除する。
     */
    public function destroy(Greeting $greeting): RedirectResponse
    {
        $greeting->delete();

        return redirect()
            ->route('greetings.index')
            ->with('status', '挨拶を削除しました。');
    }
}
