<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_manager_role()
    {
        $userData = [
            'email' => 'manager@test.com',
            'role' => 'manager',
            'password' => 'password123',
            'name' => 'Test Manager',
            'gender' => 'male',
            'age' => '30',
            'introduction' => 'Test introduction'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'email' => 'manager@test.com',
                'role' => 'manager'
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'manager@test.com',
            'role' => 'manager'
        ]);
    }

    public function test_user_can_be_created_with_worker_role()
    {
        $userData = [
            'email' => 'worker@test.com',
            'role' => 'worker',
            'password' => 'password123',
            'name' => 'Test Worker',
            'gender' => 'female',
            'age' => '25',
            'introduction' => 'Test introduction'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'email' => 'worker@test.com',
                'role' => 'worker'
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'worker@test.com',
            'role' => 'worker'
        ]);
    }

    public function test_user_cannot_be_created_with_invalid_role()
    {
        $userData = [
            'email' => 'invalid@test.com',
            'role' => 'invalid_role',
            'password' => 'password123',
            'name' => 'Test User',
            'gender' => 'male',
            'age' => '30',
            'introduction' => 'Test introduction'
        ];

        $response = $this->postJson('/api/users', $userData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['role']);
    }

    public function test_user_role_methods_work_correctly()
    {
        $manager = User::create([
            'email' => 'manager@test.com',
            'role' => 'manager',
            'password' => Hash::make('password123')
        ]);

        $worker = User::create([
            'email' => 'worker@test.com',
            'role' => 'worker',
            'password' => Hash::make('password123')
        ]);

        $this->assertTrue($manager->isManager());
        $this->assertFalse($manager->isWorker());
        $this->assertTrue($manager->hasRole('manager'));

        $this->assertTrue($worker->isWorker());
        $this->assertFalse($worker->isManager());
        $this->assertTrue($worker->hasRole('worker'));
    }

    public function test_available_roles_are_correct()
    {
        $availableRoles = User::getAvailableRoles();
        
        $this->assertEquals(['manager', 'worker'], $availableRoles);
        $this->assertCount(2, $availableRoles);
    }
} 