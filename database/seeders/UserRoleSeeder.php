<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a manager user
        $manager = User::create([
            'email' => 'manager@example.com',
            'role' => 'manager',
            'password' => Hash::make('password123'),
        ]);

        UserProfile::create([
            'user_id' => $manager->id,
            'name' => 'Manager User',
            'gender' => 'male',
            'age' => '30',
            'introduction' => 'I am a manager user.',
        ]);

        // Create a worker user
        $worker = User::create([
            'email' => 'worker@example.com',
            'role' => 'worker',
            'password' => Hash::make('password123'),
        ]);

        UserProfile::create([
            'user_id' => $worker->id,
            'name' => 'Worker User',
            'gender' => 'female',
            'age' => '25',
            'introduction' => 'I am a worker user.',
        ]);
    }
} 