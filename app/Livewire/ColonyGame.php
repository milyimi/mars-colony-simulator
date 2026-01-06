<?php

namespace App\Livewire;

use App\Models\Colony;
use Livewire\Component;
use Livewire\Attributes\On;

class ColonyGame extends Component
{
    public ?int $colonyId = null;
    public string $message = '';
    public string $messageType = '';

    public function getColonyProperty()
    {
        if (!$this->colonyId) {
            return null;
        }
        return Colony::find($this->colonyId);
    }

    public function mount()
    {
        // セッションからコロニーIDを取得
        $colonyId = session('colony_id');
        
        // セッションにIDがあれば、そのコロニーを取得
        $colony = null;
        if ($colonyId) {
            $colony = Colony::find($colonyId);
        }
        
        // コロニーが存在しないか、既に終了している場合は新規作成
        if (!$colony || !$colony->is_active) {
            $colony = Colony::create([
                'name' => '第1コロニー',
                'oxygen' => 100,
                'water' => 100,
                'power' => 100,
                'food' => 100,
                'population' => 5,
                'oxygen_facility' => 1,
                'water_facility' => 1,
                'power_facility' => 1,
                'food_facility' => 1,
            ]);
            
            // セッションに保存
            session(['colony_id' => $colony->id]);
        }
        
        $this->colonyId = $colony->id;
    }

    /**
     * 次のターンへ進む
     */
    public function nextTurn()
    {
        if (!$this->colony || !$this->colony->is_active) {
            $this->message = 'ゲームは既に終了しています。';
            $this->messageType = 'error';
            $this->dispatch('announce', message: $this->message);
            return;
        }

        $this->colony->nextTurn();

        if (!$this->colony->is_active) {
            $this->message = 'ゲームオーバー！コロニーは' . $this->colony->turn . 'ターン生き延びました。';
            $this->messageType = 'error';
        } else {
            $this->message = 'ターン' . $this->colony->turn . '：リソースが更新されました。';
            $this->messageType = 'success';
        }

        $this->dispatch('announce', message: $this->message);
    }

    /**
     * 施設を建設
     */
    public function buildFacility(string $type)
    {
        if (!$this->colony || !$this->colony->is_active) {
            $this->message = 'ゲームは既に終了しています。';
            $this->messageType = 'error';
            $this->dispatch('announce', message: $this->message);
            return;
        }

        $facilityNames = [
            'oxygen' => '酸素生成施設',
            'water' => '水生成施設',
            'power' => '発電施設',
            'food' => '食料生産施設',
        ];

        if ($this->colony->buildFacility($type)) {
            $this->message = $facilityNames[$type] . 'を建設しました！';
            $this->messageType = 'success';
        } else {
            $this->message = 'リソースが不足しています。各リソース20以上必要です。';
            $this->messageType = 'error';
        }

        $this->dispatch('announce', message: $this->message);
    }

    /**
     * ゲームをリセット
     */
    public function resetGame()
    {
        if ($this->colony) {
            $this->colony->delete();
        }
        
        // セッションから削除
        session()->forget('colony_id');
        
        // ページをリロードして新しいゲームを開始
        return redirect()->route('game');
    }

    public function render()
    {
        return view('livewire.colony-game')->layout('layouts.app');
    }
}
