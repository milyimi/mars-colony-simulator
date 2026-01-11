<?php

use App\Models\Colony;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('colony wins at turn 15 with positive resources', function () {
    $colony = Colony::create([
        'name' => 'テストコロニー',
        'oxygen' => 150,
        'water' => 150,
        'power' => 150,
        'food' => 150,
        'population' => 6,
        'oxygen_facility' => 4,
        'water_facility' => 2,
        'power_facility' => 2,
        'food_facility' => 2,
        'turn' => 0,
        'is_active' => true,
    ]);

    for ($i = 0; $i < 15; $i++) {
        $colony->nextTurn();
        $colony->refresh();
    }

    // 施設を建設していないため、モデルの時点ではゲームは継続（勝利表示はLivewire側で制御）
    expect($colony->hasWon())->toBeTrue();
    expect($colony->is_active)->toBeTrue();
});

