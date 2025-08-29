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
            ['name' => 'R134a HFC', 'gwp_value' => 1300],
            ['name' => 'R404a HFC', 'gwp_value' => 3940],
            ['name' => 'R22 HCFC', 'gwp_value' => 1760],
            ['name' => 'R403B HFC', 'gwp_value' => 3680],
            ['name' => 'R502 CFC', 'gwp_value' => 4660],
            ['name' => 'R12 CFC', 'gwp_value' => 1810],
        ];

        foreach ($refrigerants as $refrigerant) {
            DB::table('refrigerant_gwp_values')->updateOrInsert(
                ['name' => $refrigerant['name']],
                ['gwp_value' => $refrigerant['gwp_value']]
            );
        }
    }
} 