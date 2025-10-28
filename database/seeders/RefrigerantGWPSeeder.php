<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefrigerantGWPSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $refrigerants = [
            ['name' => 'R452A', 'gwp_value' => 2140],
            ['name' => 'R513a', 'gwp_value' => 631],
            ['name' => 'R32 (HFO)', 'gwp_value' => 675],
            ['name' => 'R410A', 'gwp_value' => 2088],
            ['name' => 'R408A', 'gwp_value' => 3150],
            ['name' => 'R407C (HFC)', 'gwp_value' => 1774],
        ];

        foreach ($refrigerants as $refrigerant) {
            DB::table('refrigerant_gwp_values')->updateOrInsert(
                ['name' => $refrigerant['name']],
                ['gwp_value' => $refrigerant['gwp_value']]
            );
        }
    }
} 