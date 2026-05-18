<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>挨拶フォーム</title>
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
            max-width: 440px;
            width: 100%;
            padding: 40px;
        }
        h1 { font-size: 22px; color: #2d2d52; margin-bottom: 24px; text-align: center; }
        .result {
            background: #f3f0ff;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            margin-bottom: 28px;
        }
        .result .icon { font-size: 48px; }
        .result p { font-size: 20px; color: #5b4bbd; margin-top: 8px; font-weight: 600; }
        label { display: block; font-size: 14px; color: #555; margin-bottom: 8px; }
        input[type=text] {
            width: 100%;
            padding: 12px 14px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 10px;
            outline: none;
        }
        input[type=text]:focus { border-color: #764ba2; }
        .error { color: #d33; font-size: 13px; margin-top: 6px; }
        button {
            width: 100%;
            margin-top: 20px;
            padding: 13px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background: #764ba2;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        button:hover { background: #5b3b87; }
    </style>
</head>
<body>
    <div class="card">
        <h1>挨拶フォーム</h1>

        @isset($name)
            <div class="result">
                <div class="icon">{{ $icon }}</div>
                <p>{{ $greeting }}、{{ $name }} さん！</p>
            </div>
        @endisset

        <form action="{{ route('greeting.form.submit') }}" method="POST">
            @csrf

            <label for="name">お名前</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                placeholder="例: 山田 太郎"
                autofocus
            >

            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror

            <button type="submit">挨拶する</button>
        </form>
    </div>
</body>
</html>
