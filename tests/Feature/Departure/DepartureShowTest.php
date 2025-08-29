<?php

namespace Tests\Feature\Departure;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartureShowTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->getJson('/api/departure/3');
        
        $response->assertStatus(200);
    }
}
