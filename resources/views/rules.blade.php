<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ルール説明 - 火星移住計画シミュレータ</title>
    @vite(['resources/css/app.css'])
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
            --info: #3b82f6;
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
            --info: #00ffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 18px;
            line-height: 1.8;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        *:focus {
            outline: 3px solid var(--focus-ring);
            outline-offset: 2px;
        }

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
            text-decoration: none;
            display: inline-block;
        }

        button:hover, .btn:hover {
            background: var(--text-primary);
            color: var(--bg-primary);
        }

        header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--border-color);
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 1.5rem;
            margin: 30px 0 15px;
            color: var(--text-primary);
            border-left: 4px solid var(--info);
            padding-left: 15px;
        }

        h3 {
            font-size: 1.2rem;
            margin: 20px 0 10px;
        }

        p {
            margin-bottom: 15px;
        }

        ul, ol {
            margin: 15px 0 15px 30px;
        }

        li {
            margin-bottom: 10px;
        }

        .highlight-box {
            background: var(--bg-secondary);
            border-left: 4px solid var(--info);
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .warning-box {
            background: var(--bg-secondary);
            border-left: 4px solid var(--warning);
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        .success-box {
            background: var(--bg-secondary);
            border-left: 4px solid var(--success);
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 2px solid var(--border-color);
        }

        th {
            background: var(--bg-secondary);
            font-weight: bold;
        }

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
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>🚀 火星移住計画シミュレータ - ルール説明</h1>
            <div style="margin-top: 10px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="/" class="btn">ゲームに戻る</a>
                <button onclick="toggleHighContrast()" aria-label="ハイコントラストモードを切り替え">
                    <span aria-hidden="true">🌓</span> コントラスト切替
                </button>
            </div>
        </header>

        <main id="main-content" tabindex="-1">
            <section aria-labelledby="game-overview">
                <h2 id="game-overview">ゲーム概要</h2>
                <div class="highlight-box">
                    <p><strong>火星移住計画シミュレータ</strong>は、火星に建設されたコロニーを管理するシミュレーションゲームです。</p>
                    <p>あなたの目標は、<strong>リソースを管理しながら、できるだけ長くコロニーを存続させる</strong>ことです。</p>
                </div>
            </section>

            <section aria-labelledby="basic-rules">
                <h2 id="basic-rules">基本ルール</h2>
                
                <h3>1. 4つのリソース</h3>
                <p>コロニーには管理すべき4つのリソースがあります：</p>
                <table>
                    <caption class="sr-only">リソースの詳細</caption>
                    <thead>
                        <tr>
                            <th scope="col">リソース名</th>
                            <th scope="col">説明</th>
                            <th scope="col">初期値</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">酸素</th>
                            <td>入植者が呼吸するために必要</td>
                            <td>200</td>
                        </tr>
                        <tr>
                            <th scope="row">水</th>
                            <td>飲料水や農業に使用</td>
                            <td>200</td>
                        </tr>
                        <tr>
                            <th scope="row">電力</th>
                            <td>施設の稼働に必要</td>
                            <td>200</td>
                        </tr>
                        <tr>
                            <th scope="row">食料</th>
                            <td>入植者の生存に必要</td>
                            <td>200</td>
                        </tr>
                    </tbody>
                </table>

                <h3>2. ターンシステム</h3>
                <p>「次のターンへ」ボタンをクリックすると、1ターンが経過します。各ターンごとに：</p>
                <ul>
                    <li><strong>リソースが生産されます</strong>（施設の数に応じて）</li>
                    <li><strong>リソースが消費されます</strong>（人口に応じて）</li>
                    <li><strong>人口が増加することがあります</strong>（3ターンごとに1人増加）</li>
                    <li>ターン数が1増加します</li>
                </ul>

                <h3>3. リソースの生産と消費</h3>
                <table>
                    <caption class="sr-only">各リソースの生産量と消費量</caption>
                    <thead>
                        <tr>
                            <th scope="col">リソース</th>
                            <th scope="col">施設1つあたりの生産量</th>
                            <th scope="col">入植者1人あたりの消費量</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">酸素</th>
                            <td>+10</td>
                            <td>-5</td>
                        </tr>
                        <tr>
                            <th scope="row">水</th>
                            <td>+10</td>
                            <td>-3</td>
                        </tr>
                        <tr>
                            <th scope="row">電力</th>
                            <td>+15</td>
                            <td>-4</td>
                        </tr>
                        <tr>
                            <th scope="row">食料</th>
                            <td>+8</td>
                            <td>-2</td>
                        </tr>
                    </tbody>
                </table>

                <div class="highlight-box">
                    <p><strong>計算例：</strong></p>
                    <p>人口5人、酸素生成施設が1つの場合</p>
                    <ul>
                        <li>生産: 1施設 × 10 = +10</li>
                        <li>消費: 5人 × 5 = -25</li>
                        <li>合計: 10 - 25 = <strong>-15（毎ターン15減少）</strong></li>
                    </ul>
                </div>
            </section>

            <section aria-labelledby="facilities">
                <h2 id="facilities">施設の建設</h2>
                <p>リソースを使って、新しい施設を建設できます。</p>
                
                <h3>建設コスト</h3>
                <div class="highlight-box">
                    <p>どの施設も建設には<strong>各リソース20ずつ</strong>が必要です：</p>
                    <ul>
                        <li>酸素: -20</li>
                        <li>水: -20</li>
                        <li>電力: -20</li>
                        <li>食料: -20</li>
                    </ul>
                </div>

                <h3>施設の種類</h3>
                <ol>
                    <li><strong>酸素生成施設</strong> - 毎ターン酸素を+10生産</li>
                    <li><strong>水生成施設</strong> - 毎ターン水を+10生産</li>
                    <li><strong>発電施設</strong> - 毎ターン電力を+15生産</li>
                    <li><strong>食料生産施設</strong> - 毎ターン食料を+8生産</li>
                </ol>

                <div class="success-box">
                    <p><strong>戦略のヒント：</strong></p>
                    <p>初期状態では人口5人に対して各施設が1つずつしかないため、すべてのリソースが毎ターン減少します。早めに施設を建設してバランスを取りましょう！</p>
                </div>
            </section>

            <section aria-labelledby="game-over">
                <h2 id="game-over">ゲームオーバー</h2>
                <div class="warning-box">
                    <p><strong>どれか1つでもリソースが0以下になると、ゲームオーバーです。</strong></p>
                    <ul>
                        <li>酸素が0 → 入植者が窒息</li>
                        <li>水が0 → 脱水症状</li>
                        <li>電力が0 → 施設が停止</li>
                        <li>食料が0 → 飢餓</li>
                    </ul>
                    <p>すべてのリソースを常に0より大きく保つ必要があります。</p>
                </div>
            </section>

            <section aria-labelledby="play-strategy">
                <h2 id="play-strategy">プレイ戦略</h2>
                <ol>
                    <li><strong>最初のターンでリソースの減少を確認</strong>する</li>
                    <li><strong>最も減少が激しいリソースの施設を優先的に建設</strong>する</li>
                    <li><strong>リソースのバランスを保つ</strong> - どれか1つだけ多くても意味がありません</li>
                    <li><strong>余裕ができたら追加の施設を建設</strong>して安定性を高める</li>
                    <li><strong>できるだけ長く生き延びる</strong> - 何ターン生存できるか挑戦！</li>
                </ol>
            </section>

            <section aria-labelledby="accessibility">
                <h2 id="accessibility">アクセシビリティ機能</h2>
                <p>このゲームは、すべての人が楽しめるよう設計されています：</p>

                <h3>スクリーンリーダー対応</h3>
                <ul>
                    <li>すべての情報が音声で読み上げられます</li>
                    <li>リソースの変化が自動的にアナウンスされます</li>
                    <li>適切なARIAラベルとロール設定</li>
                </ul>

                <h3>キーボード操作</h3>
                <ul>
                    <li><kbd>Tab</kbd> キーですべての要素を操作可能</li>
                    <li><kbd>Enter</kbd> または <kbd>Space</kbd> でボタンを押す</li>
                    <li><kbd>Alt + H</kbd> でハイコントラストモード切り替え</li>
                    <li><kbd>Alt + R</kbd> でルール説明ページへ移動</li>
                </ul>

                <h3>ハイコントラストモード</h3>
                <ul>
                    <li>背景が黒、文字が白の高コントラスト表示</li>
                    <li>フォーカス表示が黄色で明確</li>
                    <li>設定はブラウザに保存されます</li>
                </ul>

                <h3>視覚的な工夫</h3>
                <ul>
                    <li>大きめのフォント（18px）</li>
                    <li>明確なフォーカス表示</li>
                    <li>十分なクリック領域（48px以上）</li>
                    <li>プログレスバーと数値の両方で表示</li>
                </ul>
            </section>

            <section aria-labelledby="tips">
                <h2 id="tips">初心者向けのヒント</h2>
                <div class="success-box">
                    <ol>
                        <li><strong>最初は焦らない</strong> - ルールを理解するまで何度でもリセットできます</li>
                        <li><strong>リソース状況をよく見る</strong> - 「危険」や「不足」の表示に注意</li>
                        <li><strong>計画的に建設</strong> - リソースを使い切らないよう余裕を持って</li>
                        <li><strong>バランスが大切</strong> - すべてのリソースを均等に管理しましょう</li>
                        <li><strong>何ターン生き延びられるか挑戦</strong> - 自己ベストを更新しよう！</li>
                    </ol>
                </div>
            </section>

            <div style="margin: 40px 0; text-align: center;">
                <a href="/" class="btn" style="font-size: 1.2rem; padding: 16px 32px;">
                    ゲームを始める
                </a>
            </div>
        </main>
    </div>

    <script>
        function toggleHighContrast() {
            document.body.classList.toggle('high-contrast');
            const isHighContrast = document.body.classList.contains('high-contrast');
            localStorage.setItem('highContrast', isHighContrast);
        }

        // ページ読み込み時にハイコントラスト設定を初期化
        function initializeColorScheme() {
            const savedContrast = localStorage.getItem('highContrast');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            // ローカルストレージに保存がなければOS設定に従う
            if (savedContrast === null) {
                if (prefersDark) {
                    document.body.classList.add('high-contrast');
                }
            } else if (savedContrast === 'true') {
                // 保存された設定があればそれを使う
                document.body.classList.add('high-contrast');
            }
        }

        // OS設定の変更をリアルタイムで検出
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            const savedContrast = localStorage.getItem('highContrast');
            // ユーザーが手動設定していなければOS設定に追従
            if (savedContrast === null) {
                if (e.matches) {
                    document.body.classList.add('high-contrast');
                } else {
                    document.body.classList.remove('high-contrast');
                }
            }
        });

        // ページ読み込み時に初期化
        initializeColorScheme();
    </script>
</body>
</html>
