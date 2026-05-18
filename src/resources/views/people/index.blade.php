<x-layout title="人の登録">
    <h1>人の登録</h1>
    <p class="count">登録済み {{ $people->count() }} 人</p>

    <h2>人を追加</h2>
    <div class="card">
        <form class="add" action="{{ route('people.store') }}" method="POST">
            @csrf

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="名前（必須）"
                autofocus
            >
            <input
                type="text"
                name="role"
                value="{{ old('role') }}"
                placeholder="役割（任意）"
            >

            <button type="submit" class="btn">登録</button>
        </form>

        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror
        @error('role')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <h2>登録済みの人</h2>
    @forelse ($people as $person)
        @if ($loop->first)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>役割</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
        @endif

                    <tr>
                        <td>{{ $person->id }}</td>
                        <td>{{ $person->name }}</td>
                        <td>{{ $person->role ?? '—' }}</td>
                        <td>
                            <form
                                action="{{ route('people.destroy', $person) }}"
                                method="POST"
                                onsubmit="return confirm('この人を削除しますか？紐づく挨拶も削除されます。');"
                            >
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-del">削除</button>
                            </form>
                        </td>
                    </tr>

        @if ($loop->last)
                </tbody>
            </table>
        @endif
    @empty
        <div class="empty">まだ誰も登録されていません。</div>
    @endforelse
</x-layout>
