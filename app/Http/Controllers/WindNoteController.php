<?php

namespace App\Http\Controllers;

use App\Http\Requests\WindNote\WindNoteDeleteRequest;
use App\Http\Requests\WindNote\WindNoteIndexRequest;
use App\Http\Requests\WindNote\WindNoteShowRequest;
use App\Http\Requests\WindNote\WindNoteStoreRequest;
use App\Http\Requests\WindNote\WindNoteUpdateRequest;
use App\Models\WindNote;
use App\UseCases\WindNote\WindNoteDeleteAction;
use App\UseCases\WindNote\WindNoteIndexAction;
use App\UseCases\WindNote\WindNoteShowAction;
use App\UseCases\WindNote\WindNoteStoreAction;
use App\UseCases\WindNote\WindNoteUpdateAction;
use Illuminate\Http\Request;

class WindNoteController extends Controller
{
    public function index(WindNoteIndexRequest $request, WindNoteIndexAction $action)
    {
        return $action($request);
    }

    public function store(WindNoteStoreRequest $request, WindNoteStoreAction $action)
    {
        return $action($request);
    }
    public function show(WindNoteShowRequest $request, WindNote $windNote, WindNoteShowAction $action)
    {
        return $action($request, $windNote);
    }

    public function update(WindNoteUpdateRequest $request, WindNote $windNote, WindNoteUpdateAction $action)
    {
        return $action($request, $windNote);
    }
    public function destroy(WindNote $windNote, WindNoteDeleteAction $action)
    {
        return $action($windNote);
    }
}
