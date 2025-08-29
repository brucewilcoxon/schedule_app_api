<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $questions = Question::all();

        for ($i = 0; $i < 5; ++$i) {
            $authUser = $users->random();
            $question = $questions->random();

            Answer::factory()->create([
                'user_id' => $authUser->id,
                'question_id' => $question->id,
            ]);
        }
    }
}
