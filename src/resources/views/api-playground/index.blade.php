<x-layout title="API 練習">
    <style>
        .lead {
            color: var(--muted);
            font-size: 14.5px;
            line-height: 1.8;
            margin-bottom: 8px;
        }

        .lead code {
            background: var(--surface-strong);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 2px 7px;
            font-size: 13px;
            color: #d6ccff;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        @media (max-width: 720px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }

        .ep {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px;
            backdrop-filter: blur(10px);
        }

        .ep h3 {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .verb {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .04em;
            padding: 3px 9px;
            border-radius: 6px;
        }

        .verb.get {
            background: rgba(52, 230, 168, .15);
            color: var(--ok);
        }

        .verb.post {
            background: rgba(124, 92, 255, .18);
            color: #b9aaff;
        }

        .verb.put {
            background: rgba(255, 199, 64, .15);
            color: #ffc740;
        }

        .verb.delete {
            background: rgba(255, 93, 108, .15);
            color: var(--danger);
        }

        .ep .path {
            font-size: 13px;
            color: var(--text);
            font-family: ui-monospace, monospace;
        }

        .ep .desc {
            font-size: 12.5px;
            color: var(--muted);
            margin: 8px 0 14px;
            line-height: 1.6;
        }

        .ep .fields {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .ep input {
            padding: 9px 12px;
            font-size: 13px;
            font-family: inherit;
            color: var(--text);
            background: var(--surface-strong);
            border: 1px solid var(--border);
            border-radius: 9px;
            outline: none;
            flex: 1;
            min-width: 90px;
        }

        .ep input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 92, 255, .18);
        }

        .ep .btn {
            padding: 9px 18px;
            font-size: 13px;
            box-shadow: none;
        }

        .console {
            margin-top: 28px;
            background: #0c0c16;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .console-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 18px;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
            color: var(--muted);
        }

        .status {
            font-weight: 700;
            font-size: 12px;
            padding: 3px 10px;
            border-radius: 999px;
            background: var(--surface-strong);
            color: var(--muted);
        }

        .status.ok {
            background: rgba(52, 230, 168, .15);
            color: var(--ok);
        }

        .status.err {
            background: rgba(255, 93, 108, .15);
            color: var(--danger);
        }

        .console pre {
            margin: 0;
            padding: 18px;
            font-size: 12.5px;
            line-height: 1.65;
            font-family: ui-monospace, "SF Mono", Menlo, monospace;
            color: #d6d6e7;
            white-space: pre-wrap;
            word-break: break-word;
            max-height: 360px;
            overflow: auto;
        }

        .console pre .req {
            color: #7c8aff;
        }

        .hint {
            color: #6f6f88;
            font-size: 12px;
            margin-top: 14px;
            line-height: 1.7;
        }

        /* 保存フォーム */
        .save-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 22px;
            backdrop-filter: blur(10px);
        }

        .save-card form {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: flex-start;
        }

        .save-card input {
            padding: 11px 14px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text);
            background: var(--surface-strong);
            border: 1px solid var(--border);
            border-radius: 10px;
            outline: none;
            flex: 1;
            min-width: 160px;
        }

        .save-card input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 92, 255, .18);
        }

        .save-card .btn:disabled {
            opacity: .55;
            cursor: not-allowed;
        }

        .save-msg {
            font-size: 13px;
            margin-top: 12px;
            min-height: 18px;
        }

        .save-msg.ok {
            color: var(--ok);
        }

        .save-msg.err {
            color: var(--danger);
            white-space: pre-line;
        }

        .people-list {
            list-style: none;
            margin-top: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .people-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--surface-strong);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 11px 16px;
            font-size: 14px;
            animation: rise .3s ease both;
        }

        .people-list .pid {
            color: var(--muted);
            font-size: 12px;
            font-family: ui-monospace, monospace;
        }

        .people-list .pname {
            font-weight: 600;
        }

        .people-list .prole {
            color: var(--muted);
            font-size: 13px;
        }

        .people-list .spacer {
            flex: 1;
        }

        .people-list .btn-del {
            padding: 6px 12px;
            font-size: 12px;
        }

        .list-empty {
            color: var(--muted);
            font-size: 13px;
            margin-top: 14px;
        }
    </style>

    <h1>API 練習</h1>
    <p class="lead">
        画面ではなく <strong>JSON を返すエンドポイント</strong>（<code>/api/*</code>）を、
        下のボタンからブラウザの <code>fetch()</code> で叩いて結果を確認できます。
        同じことは <code>curl</code> や Postman でも実行できます。
    </p>

    <h2>保存フォーム（作成 → 一覧へ即反映）</h2>
    <p class="lead" style="margin-bottom:16px;">
        フォーム送信を <code>fetch()</code> で <code>POST /api/people</code> に送り、
        成功したら <code>GET /api/people</code> を呼び直して下の一覧を
        <strong>ページを再読み込みせずに</strong>更新します。
        name は必須・最大50文字。空のまま送ると <code>422</code> が返り、
        サーバーのバリデーションエラーがそのまま表示されます。
    </p>
    <div class="save-card">
        <form id="save-form" autocomplete="off">
            <input id="form-name" type="text" placeholder="name（必須）">
            <input id="form-role" type="text" placeholder="role（任意）">
            <button type="submit" class="btn" id="save-btn">保存する</button>
        </form>
        <div class="save-msg" id="save-msg"></div>

        <ul class="people-list" id="people-list"></ul>
        <p class="list-empty" id="list-empty">読み込み中…</p>
    </div>

    <h2>エンドポイント</h2>
    <div class="grid">

        <div class="ep">
            <h3><span class="verb get">GET</span> <span class="path">/api/ping</span></h3>
            <p class="desc">疎通確認。一番シンプルな GET。</p>
            <button class="btn" onclick="call('GET', '/api/ping')">送信</button>
        </div>

        <div class="ep">
            <h3><span class="verb get">GET</span> <span class="path">/api/people</span></h3>
            <p class="desc">登録済みの人を一覧で取得。</p>
            <button class="btn" onclick="call('GET', '/api/people')">送信</button>
        </div>

        <div class="ep">
            <h3><span class="verb get">GET</span> <span class="path">/api/people/{id}</span></h3>
            <p class="desc">ID を指定して 1 件取得。存在しなければ 404。</p>
            <div class="fields">
                <input id="show-id" type="text" placeholder="ID 例: 1" value="1">
            </div>
            <button class="btn" onclick="call('GET', '/api/people/' + val('show-id'))">送信</button>
        </div>

        <div class="ep">
            <h3><span class="verb post">POST</span> <span class="path">/api/people</span></h3>
            <p class="desc">新規作成。name は必須、role は任意。成功で 201。</p>
            <div class="fields">
                <input id="post-name" type="text" placeholder="name（必須）" value="山田 太郎">
                <input id="post-role" type="text" placeholder="role（任意）" value="エンジニア">
            </div>
            <button class="btn" onclick="call('POST', '/api/people', { name: val('post-name'), role: val('post-role') })">送信</button>
        </div>

        <div class="ep">
            <h3><span class="verb put">PUT</span> <span class="path">/api/people/{id}</span></h3>
            <p class="desc">指定 ID を更新。</p>
            <div class="fields">
                <input id="put-id" type="text" placeholder="ID" value="1">
                <input id="put-name" type="text" placeholder="name" value="更新後の名前">
                <input id="put-role" type="text" placeholder="role" value="リーダー">
            </div>
            <button class="btn" onclick="call('PUT', '/api/people/' + val('put-id'), { name: val('put-name'), role: val('put-role') })">送信</button>
        </div>

        <div class="ep">
            <h3><span class="verb delete">DELETE</span> <span class="path">/api/people/{id}</span></h3>
            <p class="desc">指定 ID を削除。成功で 204（本文なし）。</p>
            <div class="fields">
                <input id="del-id" type="text" placeholder="ID" value="1">
            </div>
            <button class="btn btn-del" onclick="call('DELETE', '/api/people/' + val('del-id'))">送信</button>
        </div>

    </div>

    <div class="console">
        <div class="console-bar">
            <span>レスポンス</span>
            <span class="status" id="status">未送信</span>
            <span id="meta"></span>
        </div>
        <pre id="output">ボタンを押すと、ここにリクエストとレスポンス（JSON）が表示されます。</pre>
    </div>

    <p class="hint">
        💡 ステータスコードの意味: <strong>200</strong> 成功 /
        <strong>201</strong> 作成成功 / <strong>204</strong> 成功・本文なし /
        <strong>404</strong> 見つからない / <strong>422</strong> バリデーションエラー。
    </p>

    <script>
        // 入力欄の値を取り出す小さなヘルパー
        function val(id) {
            return document.getElementById(id).value.trim();
        }

        // 実際に API を叩く本体。method と URL、必要なら body を受け取る
        async function call(method, url, body = null) {
            const out = document.getElementById('output');
            const status = document.getElementById('status');
            const meta = document.getElementById('meta');

            status.className = 'status';
            status.textContent = '送信中…';
            meta.textContent = '';

            // リクエスト内容を組み立て。JSON を送る/受け取るためのヘッダを付ける
            const options = {
                method,
                headers: {
                    'Accept': 'application/json'
                },
            };
            if (body !== null) {
                options.headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify(body);
            }

            const started = performance.now();
            try {
                const res = await fetch(url, options);
                const ms = Math.round(performance.now() - started);

                // 204 など本文が無い場合に res.json() で落ちないようにする
                const text = await res.text();
                let pretty = text;
                try {
                    pretty = JSON.stringify(JSON.parse(text), null, 2);
                } catch (_) {}

                status.className = 'status ' + (res.ok ? 'ok' : 'err');
                status.textContent = res.status + ' ' + res.statusText;
                meta.textContent = `${ms}ms`;

                const reqLine = `<span class="req">→ ${method} ${url}</span>` +
                    (body ? `\n<span class="req">  body: ${JSON.stringify(body)}</span>` : '');
                out.innerHTML = reqLine + '\n\n' + (pretty || '(本文なし)');
            } catch (e) {
                status.className = 'status err';
                status.textContent = '通信エラー';
                out.textContent = String(e);
            }
        }

        /* ===== 保存フォーム ＋ 一覧の自動更新 ===== */
        const form = document.getElementById('save-form');
        const saveBtn = document.getElementById('save-btn');
        const saveMsg = document.getElementById('save-msg');
        const listEl = document.getElementById('people-list');
        const emptyEl = document.getElementById('list-empty');

        // XSS 防止のため、ユーザー入力は必ずエスケープしてから DOM に入れる
        function esc(s) {
            return String(s ?? '').replace(/[&<>"']/g, c => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;'
            } [c]));
        }

        // GET /api/people を呼んで一覧を描画し直す
        async function loadPeople() {
            try {
                const res = await fetch('/api/people', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
                const json = await res.json();
                const people = json.data ?? [];

                listEl.innerHTML = people.map(p => `
                    <li>
                        <span class="pid">#${p.id}</span>
                        <span class="pname">${esc(p.name)}</span>
                        <span class="prole">${p.role ? esc(p.role) : '—'}</span>
                        <span class="spacer"></span>
                        <button class="btn btn-del" onclick="removePerson(${p.id})">削除</button>
                    </li>
                `).join('');

                emptyEl.style.display = people.length ? 'none' : 'block';
                emptyEl.textContent = 'まだ登録がありません。フォームから保存してみましょう。';
            } catch (e) {
                emptyEl.style.display = 'block';
                emptyEl.textContent = '一覧の取得に失敗しました: ' + e;
            }
        }

        // DELETE /api/people/{id} → 成功したら一覧を再取得
        async function removePerson(id) {
            const res = await fetch('/api/people/' + id, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json'
                },
            });
            if (res.ok) {
                saveMsg.className = 'save-msg ok';
                saveMsg.textContent = `#${id} を削除しました（DELETE → ${res.status}）`;
                loadPeople();
            } else {
                saveMsg.className = 'save-msg err';
                saveMsg.textContent = `削除に失敗しました（${res.status}）`;
            }
        }

        // フォーム送信 = POST /api/people
        form.addEventListener('submit', async (e) => {
            e.preventDefault(); // 画面遷移させず fetch で送る
            saveBtn.disabled = true;
            saveMsg.className = 'save-msg';
            saveMsg.textContent = '保存中…';

            const payload = {
                name: document.getElementById('form-name').value.trim(),
                role: document.getElementById('form-role').value.trim(),
            };

            try {
                const res = await fetch('/api/people', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });
                const json = await res.json().catch(() => ({}));

                if (res.status === 201) {
                    saveMsg.className = 'save-msg ok';
                    saveMsg.textContent = `保存しました（201 Created・ID: ${json.data?.id}）`;
                    form.reset();
                    document.getElementById('form-name').focus();
                    loadPeople(); // 一覧をページ再読み込み無しで更新
                } else if (res.status === 422) {
                    // Laravel のバリデーションエラー JSON をそのまま見せる
                    const errs = Object.values(json.errors ?? {}).flat().join('\n');
                    saveMsg.className = 'save-msg err';
                    saveMsg.textContent = `バリデーションエラー（422）\n${errs}`;
                } else {
                    saveMsg.className = 'save-msg err';
                    saveMsg.textContent = `予期しない応答: ${res.status}`;
                }
            } catch (e) {
                saveMsg.className = 'save-msg err';
                saveMsg.textContent = '通信エラー: ' + e;
            } finally {
                saveBtn.disabled = false;
            }
        });

        // 画面を開いた時点で一覧を一度読み込む
        loadPeople();
    </script>
</x-layout>