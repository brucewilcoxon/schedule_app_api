<?php

namespace Tests\Feature\WindNote;

use App\Models\WindNote;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WindNoteShowTest extends TestCase
{

    public function test_200(): void
    {
        $windNote = WindNote::factory()->create();

        $response = $this->getJson("/api/windNote/{$windNote->id}");


        $response->assertStatus(200);
    }
}
