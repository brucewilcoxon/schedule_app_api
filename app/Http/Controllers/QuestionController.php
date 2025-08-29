<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\QuestionDestroyRequest;
use App\Http\Requests\Question\QuestionIndexRequest;
use App\Http\Requests\Question\QuestionShowRequest;
use App\Http\Requests\Question\QuestionStoreRequest;
use App\Http\Requests\Question\QuestionUpdateRequest;
use App\Models\Question;
use App\UseCases\Question\QuestionDeleteAction;
use App\UseCases\Question\QuestionIndexAction;
use App\UseCases\Question\QuestionShowAction;
use App\UseCases\Question\QuestionStoreAction;
use App\UseCases\Question\QuestionUpdateAction;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(QuestionIndexRequest $request, QuestionIndexAction $action)
    {
        return $action($request);
    }

    public function store(QuestionStoreRequest $request, QuestionStoreAction $action)
    {
        return $action($request);
    }

    public function show(QuestionShowRequest $request, Question $question, QuestionShowAction $action)
    {
        return $action($request, $question);
    }

    public function update(QuestionUpdateRequest $request, Question $question, QuestionUpdateAction $action)
    {
        return $action($request, $question);
    }

    public function destroy(Question $question, QuestionDeleteAction $action)
    {
        return $action($question);
    }
}
