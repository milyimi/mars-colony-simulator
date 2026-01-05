<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>火星移住計画シミュレータ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        /* 基本スタイル */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f3f4f6;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-color: #d1d5db;
            --focus-ring: #3b82f6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
        }

        /* ハイコントラストモード */
        body.high-contrast {
            --bg-primary: #000000;
            --bg-secondary: #1a1a1a;
            --text-primary: #ffffff;
            --text-secondary: #cccccc;
            --border-color: #ffffff;
            --focus-ring: #ffff00;
            --success: #00ff00;
            --warning: #ffff00;
            --danger: #ff0000;
        }

        /* アクションボタン用の色 */
        .btn-success {
            background: #059669;
            color: white;
            border-color: #059669;
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        }

        .btn-danger {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.5);
        }

        body.high-contrast .btn-success {
            background: #00ff00;
            color: #000000;
            border-color: #00ff00;
            text-shadow: none;
        }

        body.high-contrast .btn-danger {
            background: #ff0000;
            color: #ffffff;
            border-color: #ff0000;
            text-shadow: 0 1px 2px rgba(0,0,0,0.8);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 18px;
            line-height: 1.6;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* スクリーンリーダー専用 */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }

        /* フォーカス表示 */
        *:focus {
            outline: 3px solid var(--focus-ring);
            outline-offset: 2px;
        }

        /* ボタン */
        button, .btn {
            font-size: 18px;
            padding: 12px 24px;
            border: 2px solid var(--border-color);
            background: var(--bg-secondary);
            color: var(--text-primary);
            cursor: pointer;
            border-radius: 4px;
            font-weight: 600;
            transition: all 0.2s;
            min-height: 48px;
        }

        button:hover:not(:disabled), .btn:hover:not(:disabled) {
            background: var(--text-primary);
            color: var(--bg-primary);
        }

        button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* ヘッダー */
        header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }

        h2 {
            font-size: 1.5rem;
            margin: 20px 0 10px;
        }

        /* ユーティリティ */
        .mb-4 {
            margin-bottom: 1rem;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .flex {
            display: flex;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .gap-4 {
            gap: 1rem;
        }

        /* アナウンス領域 */
        [role="status"], [role="alert"] {
            padding: 16px;
            margin: 16px 0;
            border-radius: 4px;
            font-weight: 600;
            border: 2px solid;
        }

        .status-success {
            background: var(--success);
            color: white;
            border-color: var(--success);
        }

        .status-error {
            background: var(--danger);
            color: white;
            border-color: var(--danger);
        }

        .status-warning {
            background: var(--warning);
            color: black;
            border-color: var(--warning);
        }

        /* プログレスバーのパターン */
        .progress-bar {
            position: relative;
        }

        .progress-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='10' height='10' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 10L10 0M-1 1L1 -1M9 11L11 9' stroke='rgba(0,0,0,0.25)' stroke-width='2'/%3E%3C/svg%3E");
            background-repeat: repeat;
            pointer-events: none;
            z-index: 1;
        }

        body.high-contrast .progress-bar::before {
            background-image: url("data:image/svg+xml,%3Csvg width='8' height='8' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 8L8 0M-1 1L1 -1M7 9L9 7' stroke='rgba(255,255,255,0.5)' stroke-width='2'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>火星移住計画シミュレータ</h1>
            <div class="flex gap-2" style="margin-top: 10px;">
                <button onclick="toggleHighContrast()" aria-label="ハイコントラストモードを切り替え">
                    <span aria-hidden="true">🌓</span> コントラスト切替
                </button>
                <a href="/rules" class="btn" style="text-decoration: none; display: inline-block;">
                    <span aria-hidden="true">📖</span> ルール説明
                </a>
            </div>
        </header>

        <!-- ARIA Live Region for announcements -->
        <div id="announcements" aria-live="polite" aria-atomic="true" class="sr-only"></div>

        <main id="main-content" tabindex="-1">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts

    <script>
        // ハイコントラストモード切り替え
        function toggleHighContrast() {
            document.body.classList.toggle('high-contrast');
            const isHighContrast = document.body.classList.contains('high-contrast');
            localStorage.setItem('highContrast', isHighContrast);
            
            const message = isHighContrast ? 'ハイコントラストモードを有効にしました' : 'ハイコントラストモードを無効にしました';
            announce(message);
        }

        // ページ読み込み時にハイコントラスト設定を復元
        if (localStorage.getItem('highContrast') === 'true') {
            document.body.classList.add('high-contrast');
        }

        // 音声アナウンス
        function announce(message) {
            const announcer = document.getElementById('announcements');
            announcer.textContent = message;
        }

        // Livewireイベントリスナー
        document.addEventListener('livewire:init', () => {
            Livewire.on('announce', (event) => {
                announce(event.message);
            });
        });

        // キーボードショートカット
        document.addEventListener('keydown', (e) => {
            // Alt + H: ハイコントラスト切り替え
            if (e.altKey && e.key === 'h') {
                e.preventDefault();
                toggleHighContrast();
            }
            // Alt + R: ルール説明へ移動
            if (e.altKey && e.key === 'r') {
                e.preventDefault();
                window.location.href = '/rules';
            }
        });
    </script>
</body>
</html>
