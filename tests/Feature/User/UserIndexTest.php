<?php

namespace Tests\Feature\User;

use App\Models\User;
use Tests\TestCase;

class UserIndexTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->getJson('/api/users');

        $response->assertStatus(200);
    }
}
