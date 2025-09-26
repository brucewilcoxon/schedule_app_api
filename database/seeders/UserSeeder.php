<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $users = User::factory(10)->create();

       $users->each(function ($user) {
           UserProfile::factory()->create(['user_id' => $user->id]);
       });

        $specificUser = User::create([
            'email' => 'manager@gmail.com',
            'password' => Hash::make('mrservice'),
        ]);

        UserProfile::create([
            'user_id' => $specificUser->id,
            'name' => '山田脩太',
            'gender' => 'male',
            'age' => '25',
        ]);
    }
}
