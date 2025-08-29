<?php

namespace Tests\Feature\CalendarEvent;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CalendarEventStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        // Create a user for authentication
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'role' => 'worker'
        ]);

        $response = $this->actingAs($user)->postJson('api/calendar', [
            'start' => '2024-05-29',
            'end' => '2024-05-29',
            'vehicle_info' => '冷凍車 - AB1234',
            'repair_type' => '定期点検',
            'workers' => ['田中太郎', '佐藤次郎'],
            'status' => '未開始',
            'description' => '車両の定期点検を実施。エンジン、ブレーキ、電気系統を確認。',
            'is_delayed' => false
        ]);

        $response->assertStatus(200);
    }
}
