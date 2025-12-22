<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RepairTypeOption;

class RepairTypeOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            '冷却不良',
            '異音がする',
            'ベルト鳴き',
            'エンジン始動不良',
            'ユニット作動不良',
            'スタンバイ作動不良',
            '電源入らず',
            '異臭・煙が出た',
            'ファンモーター回らず',
            '冷凍機　新規取付・載せ換え',
            'シーズンイン点検',
            '定期点検',
            '庫内洗浄',
            'オイル交換',
            'フェリー乗船前点検',
            '定置冷蔵庫　製作・修理・入替',
            'パーキングヒーター　取付・修理',
            'パーキングクーラー　取付・修理',
            '入庫',
            '出張',
            '休日・時間外緊急対応',
            '見積り・現調',
            '外注依頼',
            'その他',
        ];

        foreach ($options as $index => $name) {
            RepairTypeOption::firstOrCreate(
                ['name' => $name],
                ['order' => $index + 1]
            );
        }
    }
}
