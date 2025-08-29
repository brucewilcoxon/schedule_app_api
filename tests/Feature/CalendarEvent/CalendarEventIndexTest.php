<?php

namespace Tests\Feature\CalendarEvent;

use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalendarEventIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        // Create users first
        $users = User::factory()->count(3)->create();
        
        // Create calendar events with user_id
        foreach ($users as $user) {
            CalendarEvent::factory()->count(3)->create([
                'user_id' => $user->id
            ]);
        }

        $response = $this->getJson("/api/calendars");

        $response->assertStatus(200);
    }
}
