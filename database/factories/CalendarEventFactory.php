<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CalendarEvent>
 */
class CalendarEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('now', '+30 days')->format('Y-m-d');
        $end = $this->faker->dateTimeBetween($start, '+30 days')->format('Y-m-d');
        
        // Sample vehicle information
        $vehicleTypes = ['冷凍車', '冷蔵車', 'トラック', 'バン', 'ピックアップ'];
        $vehicleInfo = $vehicleTypes[array_rand($vehicleTypes)] . ' - ' . $this->faker->regexify('[A-Z]{2}[0-9]{4}');
        
        // Sample repair types
        $repairTypes = ['定期点検', 'エンジン修理', '冷凍機修理', 'タイヤ交換', 'ブレーキ修理', '電気系統修理', '油圧系統修理'];
        $repairType = $repairTypes[array_rand($repairTypes)];
        
        // Sample worker names (these will be replaced with actual user names in seeder)
        $sampleWorkers = ['田中太郎', '佐藤次郎', '鈴木三郎', '高橋四郎', '渡辺五郎'];
        $workers = $this->faker->randomElements($sampleWorkers, $this->faker->numberBetween(1, 3));
        
        // Status options
        $statuses = ['未開始', '進行中', '完了'];
        $status = $statuses[array_rand($statuses)];
        
        // Description based on repair type
        $descriptions = [
            '定期点検' => '車両の定期点検を実施。エンジン、ブレーキ、電気系統を確認。',
            'エンジン修理' => 'エンジンの異常音を確認。オイル交換とフィルター交換を実施。',
            '冷凍機修理' => '冷凍機の温度調整機能を修理。冷媒の補充も実施。',
            'タイヤ交換' => '摩耗したタイヤを新品に交換。バランス調整も実施。',
            'ブレーキ修理' => 'ブレーキパッドの交換。ブレーキフルードの補充も実施。',
            '電気系統修理' => 'バッテリーの点検と充電。配線の確認も実施。',
            '油圧系統修理' => '油圧ホースの交換。油圧オイルの補充も実施。'
        ];
        
        $description = $descriptions[$repairType] ?? '車両の修理作業を実施。';
        
        // Only set is_delayed to true if status is '完了'
        $isDelayed = ($status === '完了') ? $this->faker->boolean(20) : false;
        
        return [
            'start' => $start,
            'end' => $end,
            'vehicle_info' => $vehicleInfo,
            'repair_type' => $repairType,
            'workers' => $workers,
            'status' => $status,
            'description' => $description,
            'is_delayed' => $isDelayed
        ];
    }
}
