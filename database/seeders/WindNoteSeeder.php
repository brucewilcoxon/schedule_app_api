<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WindNote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WindNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        for ($i = 0; $i < 5; ++$i) {
            $authUser = $users->random();

            WindNote::factory()->create([
                'user_id' => $authUser->id,
            ]);
        }
    }
}
