<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gas;
use Carbon\Carbon;

class GasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gasData = [
            // October 14, 2025
            [
                'gas_type' => 'R-32',
                'quantity' => 50.0,
                'date' => '2025-10-14',
                'prefecture' => 'Tokyo',
                'process' => 'recovery',
            ],
            [
                'gas_type' => 'R-410A',
                'quantity' => 100.0,
                'date' => '2025-10-14',
                'prefecture' => 'Kanagawa',
                'process' => 'filling',
            ],
            // October 13, 2025
            [
                'gas_type' => 'R-32',
                'quantity' => 30.0,
                'date' => '2025-10-13',
                'prefecture' => 'Chiba',
                'process' => 'recovery',
            ],
            [
                'gas_type' => 'R-22',
                'quantity' => 50.0,
                'date' => '2025-10-13',
                'prefecture' => 'Tokyo',
                'process' => 'refilling',
            ],
            // October 12, 2025
            [
                'gas_type' => 'R-134a',
                'quantity' => 75.0,
                'date' => '2025-10-12',
                'prefecture' => 'Saitama',
                'process' => 'filling',
            ],
            [
                'gas_type' => 'R-32',
                'quantity' => 25.0,
                'date' => '2025-10-12',
                'prefecture' => 'Tokyo',
                'process' => 'recovery',
            ],
            // October 11, 2025
            [
                'gas_type' => 'R-410A',
                'quantity' => 60.0,
                'date' => '2025-10-11',
                'prefecture' => 'Kanagawa',
                'process' => 'refilling',
            ],
            [
                'gas_type' => 'R-22',
                'quantity' => 40.0,
                'date' => '2025-10-11',
                'prefecture' => 'Chiba',
                'process' => 'filling',
            ],
            // October 10, 2025
            [
                'gas_type' => 'R-134a',
                'quantity' => 80.0,
                'date' => '2025-10-10',
                'prefecture' => 'Tokyo',
                'process' => 'recovery',
            ],
            [
                'gas_type' => 'R-32',
                'quantity' => 35.0,
                'date' => '2025-10-10',
                'prefecture' => 'Saitama',
                'process' => 'filling',
            ],
        ];

        foreach ($gasData as $data) {
            Gas::create($data);
        }
    }
}
