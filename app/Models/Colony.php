<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Colony extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'oxygen',
        'water',
        'power',
        'food',
        'population',
        'oxygen_facility',
        'water_facility',
        'power_facility',
        'food_facility',
        'turn',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 次のターンを実行
     */
    public function nextTurn(): void
    {
        if (!$this->is_active) {
            return;
        }

        // リソース生産
        $this->oxygen += $this->oxygen_facility * 10;
        $this->water += $this->water_facility * 10;
        $this->power += $this->power_facility * 15;
        $this->food += $this->food_facility * 8;

        // リソース消費（人口分）
        $this->oxygen -= $this->population * 5;
        $this->water -= $this->population * 3;
        $this->power -= $this->population * 4;
        $this->food -= $this->population * 2;

        // 上限設定
        $this->oxygen = min($this->oxygen, 200);
        $this->water = min($this->water, 200);
        $this->power = min($this->power, 200);
        $this->food = min($this->food, 200);

        // ゲームオーバー判定
        if ($this->oxygen <= 0 || $this->water <= 0 || $this->power <= 0 || $this->food <= 0) {
            $this->is_active = false;
        }

        $this->turn++;

        // 人口増加（3ターンごとに1人加わる）
        if ($this->turn % 3 === 0) {
            $this->population++;
        }

        $this->save();
    }

    /**
     * 施設を建設
     */
    public function buildFacility(string $type): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // 建設コスト
        $cost = [
            'oxygen' => 20,
            'water' => 20,
            'power' => 20,
            'food' => 20,
        ];

        // リソースチェック
        if ($this->oxygen < $cost['oxygen'] || 
            $this->water < $cost['water'] || 
            $this->power < $cost['power'] || 
            $this->food < $cost['food']) {
            return false;
        }

        // リソース消費
        $this->oxygen -= $cost['oxygen'];
        $this->water -= $cost['water'];
        $this->power -= $cost['power'];
        $this->food -= $cost['food'];

        // 施設追加（Eloquent属性を直接加算）
        $facilityColumn = $type . '_facility';
        $current = (int) ($this->$facilityColumn ?? 0);
        $this->$facilityColumn = $current + 1;

        $this->save();
        return true;
    }

    /**
     * リソースの状態を取得
     */
    public function getResourceStatus(string $resource): string
    {
        $value = $this->$resource;
        
        if ($value <= 0) {
            return '危険';
        } elseif ($value < 30) {
            return '不足';
        } elseif ($value < 70) {
            return '普通';
        } else {
            return '十分';
        }
    }

    /**
     * 勝利条件を判定
     */
    public function hasWon(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $resourcesPositive = $this->oxygen > 0
            && $this->water > 0
            && $this->power > 0
            && $this->food > 0;

        return $this->turn >= 15 && $resourcesPositive;
    }
}
