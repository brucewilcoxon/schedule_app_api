<?php

namespace Tests\Feature\Answer;

use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnswerStoreTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_200(): void
    {
        $question = Question::factory()->create();

        $answer = [
            'content' => 'テストです',
            'question_id' => $question->id,
        ];

        $response = $this->postJson('/api/answer', $answer);

        $response->assertStatus(200);
    }
}
