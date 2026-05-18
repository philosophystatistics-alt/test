<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>挨拶ページ</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: system-ui, "Hiragino Sans", "Noto Sans JP", sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, .2);
            max-width: 480px;
            width: 100%;
            padding: 40px;
        }
        .icon { font-size: 56px; text-align: center; }
        h1 {
            text-align: center;
            font-size: 26px;
            margin: 12px 0 4px;
            color: #2d2d52;
        }
        .time { text-align: center; color: #888; font-size: 14px; margin-bottom: 28px; }
        .hint {
            background: #f3f0ff;
            color: #5b4bbd;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 14px;
            margin-bottom: 28px;
        }
        .hint code { background: #e4dcff; padding: 2px 6px; border-radius: 4px; }
        h2 { font-size: 16px; color: #555; margin-bottom: 12px; }
        ul { list-style: none; }
        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            border-radius: 10px;
            background: #f7f7fb;
            margin-bottom: 8px;
        }
        li .role {
            font-size: 12px;
            color: #fff;
            background: #764ba2;
            padding: 3px 10px;
            border-radius: 999px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">{{ $icon }}</div>

        @if ($name)
            <h1>{{ $greeting }}、{{ $name }} さん！</h1>
        @else
            <h1>{{ $greeting }}！</h1>
        @endif

        <p class="time">{{ $time }} 現在</p>

        @unless ($name)
            <div class="hint">
                URL の末尾に名前を付けると個別に挨拶します。<br>
                例: <code>/greeting/太郎</code>
            </div>
        @endunless

        <h2>登録されている人</h2>
        <ul>
            @forelse ($people as $person)
                <li>
                    <span>{{ $greeting }}、{{ $person['name'] }} さん</span>
                    <span class="role">{{ $person['role'] }}</span>
                </li>
            @empty
                <li>まだ誰も登録されていません。</li>
            @endforelse
        </ul>
    </div>
</body>
</html>
