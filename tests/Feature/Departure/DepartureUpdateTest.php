<?php

namespace Tests\Feature\Departure;

use App\Models\Departure;
use App\Models\User;
use Tests\TestCase;

class DepartureUpdateTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        $user = User::first();

        $departure = Departure::factory()->for($user)->create();

        $response = $this->actingAs($user)->putJson("/api/departure/{$departure->id}", [
            'start' => '2024-08-07T09:21:58.000000Z',
            'end' => '2024-08-07T10:21:58.000000Z',
            'description' => '道具整備のため'
        ]);

        $response->assertStatus(200);
    }
}
