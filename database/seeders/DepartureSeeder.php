<?php

namespace Database\Seeders;

use App\Models\Departure;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class DepartureSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        for ($i = 0; $i < 5; ++$i) {
            $authUser = $users->random();
            $intraUser = $users->random();

            // user_idとintra_user_idが異なるようにする
            while ($intraUser->id === $authUser->id) {
                $intraUser = $users->random();
            }

            // 50%の確率でintra_user_idをnullにする
            $intraUserId = $this->faker->randomElement([null, $intraUser->id]);

            Departure::factory()->create([
                'user_id' => $authUser->id,
            ]);
        }
    }
}