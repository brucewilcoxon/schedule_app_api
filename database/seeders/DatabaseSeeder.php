<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UserRoleSeeder::class,
            DepartureSeeder::class,
            CalendarEventSeeder::class,
            WindNoteSeeder::class,
            QuestionSeeder::class,
            AnswerSeeder::class,
            IntraClaimSeeder::class,
            RefrigerantGWPSeeder::class,
        ]);
    }
}
