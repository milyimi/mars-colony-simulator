<?php

namespace App\Livewire;

use App\Models\Colony;
use Livewire\Component;
use Livewire\Attributes\On;

class ColonyGame extends Component
{
    public Colony $colony;
    public string $message = '';
    public string $messageType = '';

    public function mount()
    {
        // 既存のアクティブなコロニーを取得、なければ新規作成
        $this->colony = Colony::where('is_active', true)->first() ?? Colony::create([
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
    }

    /**
     * 次のターンへ進む
     */
    public function nextTurn()
    {
        if (!$this->colony->is_active) {
            $this->message = 'ゲームは既に終了しています。';
            $this->messageType = 'error';
            $this->dispatch('announce', message: $this->message);
            return;
        }

        $this->colony->nextTurn();
        $this->colony->refresh();

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
        if (!$this->colony->is_active) {
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
            $this->colony->refresh();
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
        $this->colony->delete();
        $this->mount();
        $this->message = '新しいゲームを開始しました！';
        $this->messageType = 'success';
        $this->dispatch('announce', message: $this->message);
    }

    public function render()
    {
        return view('livewire.colony-game')->layout('layouts.app');
    }
}
