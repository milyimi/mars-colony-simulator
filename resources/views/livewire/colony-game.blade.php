<div>
    @if(!$this->colony)
        <div role="alert" class="status-error">
            読み込み中...
        </div>
    @else
    {{-- メッセージ表示 --}}
    @if($message)
        <div role="{{ $messageType === 'error' ? 'alert' : 'status' }}" 
             class="status-{{ $messageType }}"
             aria-live="assertive">
            {{ $message }}
        </div>
    @endif

    {{-- ゲーム状態 --}}
    <section aria-labelledby="game-status">
        <h2 id="game-status">ゲーム状態</h2>
        <div style="background: var(--bg-secondary); padding: 20px; border-radius: 8px; margin-bottom: 20px;">
            <dl style="display: grid; grid-template-columns: auto 1fr; gap: 10px 20px;">
                <dt><strong>コロニー名:</strong></dt>
                <dd>{{ $this->colony->name }}</dd>
                
                <dt><strong>ターン数:</strong></dt>
                <dd>{{ $this->colony->turn }}</dd>
                
                <dt><strong>人口:</strong></dt>
                <dd>{{ $this->colony->population }}人</dd>
                
                <dt><strong>状態:</strong></dt>
                <dd>
                    @if($this->colony->is_active)
                        <span style="color: var(--success);">稼働中</span>
                    @else
                        <span style="color: var(--danger);">終了</span>
                    @endif
                </dd>
            </dl>
        </div>
    </section>

    {{-- リソース状況 --}}
    <section aria-labelledby="resources">
        <h2 id="resources">リソース状況</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
            @foreach(['oxygen' => '酸素', 'water' => '水', 'power' => '電力', 'food' => '食料'] as $key => $label)
                <div style="background: var(--bg-secondary); padding: 20px; border-radius: 8px; border: 2px solid var(--border-color);"
                     role="region" 
                     aria-label="{{ $label }}の状態">
                    <h3 style="font-size: 1.2rem; margin-bottom: 10px;">
                        {{ $label }}
                        <span class="sr-only">: {{ $this->colony->$key }}. 状態: {{ $this->colony->getResourceStatus($key) }}</span>
                    </h3>
                    
                    <div style="font-size: 2rem; font-weight: bold; margin: 10px 0;"
                         aria-hidden="true">
                        {{ $this->colony->$key }}
                    </div>
                    
                    <div style="margin: 10px 0;">
                        <div style="background: var(--bg-primary); height: 30px; border-radius: 4px; overflow: hidden; border: 3px solid var(--border-color); position: relative;">
                            <div class="progress-bar"
                                 style="height: 100%; 
                                        width: {{ min($this->colony->$key / 2, 100) }}%;
                                        transition: width 0.3s;
                                        border-right: {{ min($this->colony->$key / 2, 100) < 100 ? '3px solid var(--border-color)' : 'none' }};
                                        background-color: {{ $this->colony->$key > 50 ? 'var(--success)' : ($this->colony->$key > 20 ? 'var(--warning)' : 'var(--danger)') }};"
                                 role="progressbar"
                                 aria-valuenow="{{ $this->colony->$key }}"
                                 aria-valuemin="0"
                                 aria-valuemax="200"
                                 aria-label="{{ $label }}の量"></div>
                        </div>
                    </div>
                    
                    <div style="margin-top: 10px;">
                        <strong>状態:</strong> 
                        <span style="color: {{ $this->colony->$key > 50 ? 'var(--success)' : ($this->colony->$key > 20 ? 'var(--warning)' : 'var(--danger)') }}">
                            {{ $this->colony->getResourceStatus($key) }}
                        </span>
                    </div>
                    
                    <div style="margin-top: 5px; color: var(--text-secondary);">
                        <span class="sr-only">毎ターンの生産量: </span>
                        生産: +{{ $this->colony->{$key . '_facility'} * (match($key) {
                            'oxygen' => 10,
                            'water' => 10,
                            'power' => 15,
                            'food' => 8,
                        }) }}
                    </div>
                    <div style="color: var(--text-secondary);">
                        <span class="sr-only">毎ターンの消費量: </span>
                        消費: -{{ $this->colony->population * (match($key) {
                            'oxygen' => 5,
                            'water' => 3,
                            'power' => 4,
                            'food' => 2,
                        }) }}
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- 施設建設 --}}
    <section aria-labelledby="facilities">
        <h2 id="facilities">施設建設</h2>
        <p style="margin-bottom: 15px; color: var(--text-secondary);">
            建設コスト: 各リソース20必要です。施設を建設するとリソースの生産量が増加します。
        </p>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-bottom: 30px;">
            @foreach(['oxygen' => '酸素生成施設', 'water' => '水生成施設', 'power' => '発電施設', 'food' => '食料生産施設'] as $key => $label)
                <div style="background: var(--bg-secondary); padding: 15px; border-radius: 8px;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 10px;">{{ $label }}</h3>
                    <div style="margin-bottom: 10px;">
                        <strong>現在数:</strong> {{ $this->colony->{$key . '_facility'} }}施設
                    </div>
                    <button wire:click="buildFacility('{{ $key }}')"
                            @if(!$this->colony->is_active) disabled @endif
                            aria-label="{{ $label }}を建設する。コスト: 各リソース20">
                        建設する
                    </button>
                </div>
            @endforeach
        </div>
    </section>

    {{-- アクション --}}
    <section aria-labelledby="actions">
        <h2 id="actions">アクション</h2>
        <div class="flex gap-4" style="flex-wrap: wrap;">
            <button wire:click="nextTurn"
                    @if(!$this->colony->is_active) disabled @endif
                    class="btn-success"
                    aria-label="次のターンに進む。リソースが生産・消費されます。">
                <span aria-hidden="true">▶️</span> 次のターンへ
            </button>
            
            <button wire:click="resetGame"
                    class="btn-danger"
                    aria-label="ゲームをリセットして最初からやり直す"
                    onclick="return confirm('本当にゲームをリセットしますか？')">
                <span aria-hidden="true">🔄</span> リセット
            </button>
        </div>
    </section>

    {{-- キーボードショートカットヘルプ --}}
    <details style="margin-top: 30px; padding: 20px; background: var(--bg-secondary); border-radius: 8px;">
        <summary style="cursor: pointer; font-weight: bold; font-size: 1.1rem;">
            キーボードショートカット
        </summary>
        <dl style="margin-top: 15px; display: grid; grid-template-columns: auto 1fr; gap: 10px 20px;">
            <dt><kbd>Alt + H</kbd></dt>
            <dd>ハイコントラストモード切り替え</dd>
            
            <dt><kbd>Alt + R</kbd></dt>
            <dd>ルール説明ページへ移動</dd>
            
            <dt><kbd>Tab</kbd></dt>
            <dd>次の要素へ移動</dd>
            
            <dt><kbd>Shift + Tab</kbd></dt>
            <dd>前の要素へ移動</dd>
            
            <dt><kbd>Enter</kbd> または <kbd>Space</kbd></dt>
            <dd>ボタンを押す</dd>
        </dl>
    </details>
@endif
</div>
