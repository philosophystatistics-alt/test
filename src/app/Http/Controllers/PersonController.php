<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    /**
     * 人の登録フォームと登録済み一覧を表示する。
     */
    public function index(): View
    {
        $people = Person::orderBy('name')->get();

        return view('people.index', [
            'people' => $people,
        ]);
    }

    /**
     * 人を1人登録する。
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'role' => ['nullable', 'string', 'max:50'],
        ], [
            'name.required' => '名前を入力してください。',
            'name.max'      => '名前は50文字以内で入力してください。',
            'role.max'      => '役割は50文字以内で入力してください。',
        ]);

        Person::create($validated);

        return redirect()
            ->route('people.index')
            ->with('status', '人を登録しました。');
    }

    /**
     * 人を1人削除する（紐づく挨拶も cascade で削除される）。
     */
    public function destroy(Person $person): RedirectResponse
    {
        $person->delete();

        return redirect()
            ->route('people.index')
            ->with('status', '人を削除しました。');
    }
}
