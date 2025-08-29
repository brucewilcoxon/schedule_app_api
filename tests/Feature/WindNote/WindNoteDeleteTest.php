<?php

namespace Tests\Feature\WindNote;

use App\Models\WindNote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WindNoteDeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        $windNote = WindNote::factory()
            ->create();

        $response = $this->deleteJson("/api/windNote/{$windNote->id}");
        dump($response->json());
        $response->assertStatus(200);
    }
}
