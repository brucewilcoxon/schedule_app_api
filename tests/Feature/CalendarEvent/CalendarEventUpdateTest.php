<?php

namespace Tests\Feature\CalendarEvent;

use App\Models\CalendarEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalendarEventUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_update_their_event(): void
    {
        $user = User::factory()->create(['role' => 'worker']);
        $calendarEvent = CalendarEvent::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->putJson("api/calendar/{$calendarEvent->id}", [
            'start' => '2024-05-29',
            'end' => '2024-05-29',
            'vehicle_info' => 'Updated Vehicle Info',
            'repair_type' => '定期点検',
            'workers' => ['田中太郎', '佐藤次郎'],
            'status' => '進行中',
            'description' => 'Updated description',
            'is_delayed' => false
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('calendar_events', [
            'id' => $calendarEvent->id,
            'vehicle_info' => 'Updated Vehicle Info',
            'status' => '進行中'
        ]);
    }

    public function test_manager_can_update_any_event(): void
    {
        $manager = User::factory()->create(['role' => 'manager']);
        $worker = User::factory()->create(['role' => 'worker']);
        $calendarEvent = CalendarEvent::factory()->create(['user_id' => $worker->id]);

        $response = $this->actingAs($manager)->putJson("api/calendar/{$calendarEvent->id}", [
            'start' => '2024-05-29',
            'end' => '2024-05-29',
            'vehicle_info' => 'Manager Updated Vehicle Info',
            'repair_type' => '定期点検',
            'workers' => ['田中太郎', '佐藤次郎'],
            'status' => '完了',
            'description' => 'Manager updated description',
            'is_delayed' => false
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('calendar_events', [
            'id' => $calendarEvent->id,
            'vehicle_info' => 'Manager Updated Vehicle Info',
            'status' => '完了'
        ]);
    }

    public function test_worker_cannot_update_other_workers_event(): void
    {
        $worker1 = User::factory()->create(['role' => 'worker']);
        $worker2 = User::factory()->create(['role' => 'worker']);
        $calendarEvent = CalendarEvent::factory()->create(['user_id' => $worker1->id]);

        $response = $this->actingAs($worker2)->putJson("api/calendar/{$calendarEvent->id}", [
            'start' => '2024-05-29',
            'end' => '2024-05-29',
            'vehicle_info' => 'Unauthorized Update',
            'repair_type' => '定期点検',
            'workers' => ['田中太郎', '佐藤次郎'],
            'status' => '進行中',
            'description' => 'Unauthorized description',
            'is_delayed' => false
        ]);

        $response->assertStatus(403);
        $response->assertJson([
            'message' => 'イベントの編集をする権限がありません'
        ]);
    }
}
