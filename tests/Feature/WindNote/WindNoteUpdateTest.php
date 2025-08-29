<?php

namespace Tests\Feature\WindNote;

use App\Models\WindNote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WindNoteUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_200(): void
    {
        $windNote = WindNote::factory()->create();

        $data = [
            'title' => 'updateタイトル',
            'content' => 'update内容',
        ];

        $response = $this->putJson("/api/windNote/{$windNote->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('wind_notes', [
            'id' => $windNote->id,
            'title' => 'updateタイトル',
            'content' => 'update内容',
        ]);
    }
}
