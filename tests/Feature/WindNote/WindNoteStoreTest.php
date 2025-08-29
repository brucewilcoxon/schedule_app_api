<?php

namespace Tests\Feature\WindNote;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WindNoteStoreTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        $response = $this->postJson('/api/windNote', [
            'title' => '今日の練習',
            'content' => '内容が入ります',
            'date' => '2023-06-07'
        ]);

        $response->assertStatus(200);
    }
}
