<?php

namespace Tests\Feature\CalendarEvent;

use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalendarEventDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_delete_their_event(): void
    {
        $user = User::factory()->create(['role' => 'worker']);
        $calendarEvent = CalendarEvent::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->deleteJson("api/calendar/{$calendarEvent->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('calendar_events', [
            'id' => $calendarEvent->id
        ]);
    }

    public function test_manager_can_delete_any_event(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $worker = User::factory()->create(['role' => 'worker']);
        $calendarEvent = CalendarEvent::factory()->create(['user_id' => $worker->id]);

        $response = $this->actingAs($manager)->deleteJson("api/calendar/{$calendarEvent->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('calendar_events', [
            'id' => $calendarEvent->id
        ]);
    }

    public function test_worker_cannot_delete_other_workers_event(): void
    {
        $worker1 = User::factory()->create(['role' => 'worker']);
        $worker2 = User::factory()->create(['role' => 'worker']);
        $calendarEvent = CalendarEvent::factory()->create(['user_id' => $worker1->id]);

        $response = $this->actingAs($worker2)->deleteJson("api/calendar/{$calendarEvent->id}");

        $response->assertStatus(403);
        $response->assertJson([
            'message' => '削除する権限がありません'
        ]);
        
        // Event should still exist
        $this->assertDatabaseHas('calendar_events', [
            'id' => $calendarEvent->id
        ]);
    }
}
