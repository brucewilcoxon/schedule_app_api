<?php

namespace Database\Seeders;

use App\Models\IntraClaim;
use App\Models\User;
use Illuminate\Database\Seeder;

class IntraClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        for ($i = 0; $i < 5; $i++) {
            $authUser = $users->random();

            $user = User::factory()->create();

            IntraClaim::factory()->create([
                'intra_user_id' => $authUser->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
