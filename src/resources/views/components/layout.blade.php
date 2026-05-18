@props(['title' => 'アプリ'])

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    {{-- Google Fonts は非ブロッキングで読み込む（オフライン/低速環境でも
         画面が固まらないように）。取得できれば適用、できなければ
         下の <style> 内 system-ui フォールバックで即描画される。 --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap"
          media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet"
              href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap">
    </noscript>
    <style>
        :root {
            --bg: #0b0b14;
            --surface: rgba(255, 255, 255, .04);
            --surface-strong: rgba(255, 255, 255, .07);
            --border: rgba(255, 255, 255, .08);
            --text: #e8e8f0;
            --muted: #9a9ab0;
            --accent: #7c5cff;
            --accent-2: #c04bff;
            --danger: #ff5d6c;
            --ok: #34e6a8;
            --radius: 18px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: "Inter", "Noto Sans JP", system-ui, sans-serif;
            color: var(--text);
            min-height: 100vh;
            background: var(--bg);
            position: relative;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }
        /* グラデーションのオーロラ背景 */
        body::before {
            content: "";
            position: fixed;
            inset: -30%;
            z-index: -1;
            background:
                radial-gradient(40rem 40rem at 15% 10%, rgba(124, 92, 255, .35), transparent 60%),
                radial-gradient(35rem 35rem at 85% 20%, rgba(192, 75, 255, .28), transparent 60%),
                radial-gradient(40rem 40rem at 50% 100%, rgba(52, 230, 168, .18), transparent 60%);
            filter: blur(20px);
            animation: drift 18s ease-in-out infinite alternate;
        }
        @keyframes drift {
            from { transform: translate3d(0, 0, 0) scale(1); }
            to   { transform: translate3d(0, -4%, 0) scale(1.08); }
        }

        /* ナビ：グラスモーフィズム + スティッキー */
        .nav {
            position: sticky;
            top: 0;
            z-index: 10;
            display: flex;
            gap: 6px;
            align-items: center;
            padding: 16px 28px;
            background: rgba(15, 15, 26, .55);
            backdrop-filter: saturate(160%) blur(18px);
            -webkit-backdrop-filter: saturate(160%) blur(18px);
            border-bottom: 1px solid var(--border);
        }
        .nav .brand {
            font-weight: 700;
            font-size: 15px;
            letter-spacing: .02em;
            margin-right: 20px;
            background: linear-gradient(120deg, #fff, #c9bfff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .nav a {
            color: var(--muted);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 999px;
            transition: color .2s, background .2s;
        }
        .nav a:hover { color: var(--text); background: var(--surface); }
        .nav a.active {
            color: #fff;
            background: linear-gradient(120deg, var(--accent), var(--accent-2));
            box-shadow: 0 6px 20px rgba(124, 92, 255, .4);
        }

        .container {
            max-width: 820px;
            margin: 0 auto;
            padding: 56px 24px 80px;
            animation: rise .5s cubic-bezier(.2, .7, .2, 1) both;
        }
        @keyframes rise {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: none; }
        }

        h1 {
            font-size: 30px;
            font-weight: 700;
            letter-spacing: -.02em;
            margin-bottom: 6px;
            background: linear-gradient(120deg, #ffffff, #b9aaff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        h2 {
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .12em;
            color: var(--muted);
            margin: 36px 0 14px;
        }
        .count { color: var(--muted); font-size: 14px; margin-bottom: 24px; }

        .flash {
            display: flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(120deg, rgba(52, 230, 168, .14), rgba(52, 230, 168, .06));
            border: 1px solid rgba(52, 230, 168, .35);
            color: var(--ok);
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 24px;
            animation: rise .4s ease both;
        }
        .flash::before { content: "✓"; font-weight: 700; }

        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 24px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 18px 50px rgba(0, 0, 0, .35);
        }

        form.add { display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-start; }
        select, input[type=text] {
            padding: 12px 16px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text);
            background: var(--surface-strong);
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            transition: border-color .2s, box-shadow .2s, background .2s;
        }
        select { color: var(--text); }
        select option { background: #16161f; color: var(--text); }
        input[type=text] { flex: 1; min-width: 200px; }
        input::placeholder { color: #6f6f88; }
        select:focus, input[type=text]:focus {
            border-color: var(--accent);
            background: rgba(124, 92, 255, .08);
            box-shadow: 0 0 0 4px rgba(124, 92, 255, .18);
        }

        .btn {
            padding: 12px 22px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            color: #fff;
            background: linear-gradient(120deg, var(--accent), var(--accent-2));
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: transform .15s ease, box-shadow .2s ease, filter .2s;
            box-shadow: 0 10px 26px rgba(124, 92, 255, .38);
        }
        .btn:hover { transform: translateY(-1px); filter: brightness(1.08); box-shadow: 0 14px 32px rgba(124, 92, 255, .5); }
        .btn:active { transform: translateY(0); }
        .btn-del {
            background: rgba(255, 93, 108, .12);
            color: var(--danger);
            border: 1px solid rgba(255, 93, 108, .35);
            padding: 8px 14px;
            font-size: 13px;
            box-shadow: none;
        }
        .btn-del:hover {
            background: rgba(255, 93, 108, .2);
            filter: none;
            box-shadow: 0 8px 20px rgba(255, 93, 108, .25);
        }
        .error { color: var(--danger); font-size: 13px; margin-top: 10px; }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 4px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            overflow: hidden;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        th, td { padding: 16px 18px; text-align: left; font-size: 14px; }
        th {
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--muted);
            background: rgba(255, 255, 255, .03);
            border-bottom: 1px solid var(--border);
        }
        td { border-bottom: 1px solid var(--border); color: var(--text); }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr { transition: background .15s; }
        tbody tr:hover td { background: rgba(124, 92, 255, .07); }

        /* 集計サマリー */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 14px;
            margin-bottom: 8px;
        }
        .stat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px 22px;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .stat .num {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -.02em;
            background: linear-gradient(120deg, #fff, #b9aaff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .stat .label {
            font-size: 12px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .1em;
            margin-top: 4px;
        }
        /* 人ごとの挨拶数バー */
        .bars { display: flex; flex-direction: column; gap: 12px; }
        .bar-row { display: grid; grid-template-columns: 130px 1fr 44px; align-items: center; gap: 14px; }
        .bar-name { font-size: 13.5px; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .bar-track { height: 10px; background: rgba(255, 255, 255, .06); border-radius: 999px; overflow: hidden; }
        .bar-fill {
            height: 100%;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--accent), var(--accent-2));
            box-shadow: 0 0 14px rgba(124, 92, 255, .5);
            animation: grow .6s cubic-bezier(.2, .7, .2, 1) both;
        }
        @keyframes grow { from { width: 0 !important; } }
        .bar-val { font-size: 13px; font-weight: 600; color: var(--muted); text-align: right; }

        .empty {
            background: var(--surface);
            border: 1px dashed var(--border);
            border-radius: var(--radius);
            padding: 56px;
            text-align: center;
            color: var(--muted);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <nav class="nav">
        <span class="brand">✦ 挨拶アプリ</span>
        <a href="{{ route('people.index') }}"
           class="{{ request()->routeIs('people.*') ? 'active' : '' }}">人の登録</a>
        <a href="{{ route('greetings.index') }}"
           class="{{ request()->routeIs('greetings.*') ? 'active' : '' }}">挨拶一覧</a>
        <a href="{{ route('images.index') }}"
           class="{{ request()->routeIs('images.*') ? 'active' : '' }}">画像アップロード</a>
    </nav>

    <div class="container">
        @if (session('status'))
            <div class="flash">{{ session('status') }}</div>
        @endif

        {{ $slot }}
    </div>
</body>
</html>
