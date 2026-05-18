<x-layout title="挨拶一覧">
    <h1>挨拶一覧</h1>
    <p class="count">全 {{ $stats['total'] }} 件</p>

    <h2>集計</h2>
    <div class="stats">
        <div class="stat">
            <div class="num">{{ $stats['total'] }}</div>
            <div class="label">総挨拶数</div>
        </div>
        <div class="stat">
            <div class="num">{{ $stats['people'] }}</div>
            <div class="label">挨拶した人数</div>
        </div>
        <div class="stat">
            <div class="num">{{ $stats['maxPerPerson'] }}</div>
            <div class="label">最多 / 1人</div>
        </div>
    </div>

    @if ($countsByPerson->isNotEmpty())
        <h2>人ごとの挨拶数</h2>
        <div class="card">
            <div class="bars">
                @foreach ($countsByPerson as $name => $count)
                    <div class="bar-row">
                        <span class="bar-name">{{ $name }}</span>
                        <span class="bar-track">
                            <span class="bar-fill"
                                  style="width: {{ $stats['maxPerPerson'] > 0 ? round($count / $stats['maxPerPerson'] * 100) : 0 }}%"></span>
                        </span>
                        <span class="bar-val">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <h2>挨拶を追加</h2>
    <div class="card">
        <form class="add" action="{{ route('greetings.store') }}" method="POST">
            @csrf

            <select name="person_id">
                <option value="">-- 人を選択 --</option>
                @foreach ($people as $person)
                    <option value="{{ $person->id }}" @selected(old('person_id') == $person->id)>
                        {{ $person->name }}
                    </option>
                @endforeach
            </select>

            <input
                type="text"
                name="message"
                value="{{ old('message') }}"
                placeholder="挨拶メッセージ"
            >

            <button type="submit" class="btn">追加</button>
        </form>

        @error('person_id')
            <p class="error">{{ $message }}</p>
        @enderror
        @error('message')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <h2>登録済みの挨拶</h2>
    @forelse ($greetings as $greeting)
        @if ($loop->first)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>名前</th>
                        <th>挨拶メッセージ</th>
                        <th>登録日時</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
        @endif

                    <tr>
                        <td>{{ $greeting->id }}</td>
                        <td>{{ $greeting->person?->name ?? '（不明）' }}</td>
                        <td>{{ $greeting->message }}</td>
                        <td>{{ $greeting->created_at->format('Y/m/d H:i') }}</td>
                        <td>
                            <form
                                action="{{ route('greetings.destroy', $greeting) }}"
                                method="POST"
                                onsubmit="return confirm('この挨拶を削除しますか？');"
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
        <div class="empty">まだ挨拶が登録されていません。</div>
    @endforelse
</x-layout>
