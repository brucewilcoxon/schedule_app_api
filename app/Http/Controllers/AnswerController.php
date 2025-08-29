<?php

namespace App\Http\Controllers;

use App\Http\Requests\Answer\AnswerIndexRequest;
use App\Http\Requests\Answer\AnswerStoreRequest;
use App\Http\Requests\Answer\AnswerUpdateRequest;
use App\Models\Answer;
use App\UseCases\Answer\AnswerDeleteAction;
use App\UseCases\Answer\AnswerIndexAction;
use App\UseCases\Answer\AnswerStoreAction;
use App\UseCases\Answer\AnswerUpdateAction;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index(AnswerIndexRequest $request, AnswerIndexAction $action)
    {
        return $action($request);
    }
    public function store(AnswerStoreRequest $request, AnswerStoreAction $action)
    {
        return $action($request);
    }

    public function update(AnswerUpdateRequest $request, Answer $answer, AnswerUpdateAction $action)
    {
        return $action($request, $answer);
    }
    public function destroy(Answer $answer, AnswerDeleteAction $action)
    {
        return $action($answer);
    }
}
