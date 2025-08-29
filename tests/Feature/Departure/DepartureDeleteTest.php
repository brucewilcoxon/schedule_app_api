<?php

namespace Tests\Feature\Departure;

use App\Models\Departure;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DepartureDeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        $user = User::first();

        $departure = Departure::factory()->for($user)->create();

        $response = $this->actingAs($user)->deleteJson("/api/departure/{$departure->id}");
        
        $response->assertStatus(200);
    }
}
