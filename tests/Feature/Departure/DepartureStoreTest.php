<?php

namespace Tests\Feature\Departure;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartureStoreTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        $user = User::first();

        $response = $this->actingAs($user)->postJson('/api/departure',[
            'intra_user_id' => 3,
            'start' => '2024-08-07T10:21:58.000000Z',
            'end' => '2024-08-07T10:21:58.000000Z',
            'description' => '道具整備のため'
        ]);
        $response->dump();
        $response->assertStatus(200);
    }
}
