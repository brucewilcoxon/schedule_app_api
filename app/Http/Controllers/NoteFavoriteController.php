<?php

namespace App\Http\Controllers;

use App\Models\WindNote;
use App\UseCases\WindNote\NoteFavoriteShowAction;
use App\UseCases\WindNote\NoteFavoriteUpdateAction;
use Illuminate\Http\Request;

class NoteFavoriteController extends Controller
{
    public function show(WindNote $windNote, NoteFavoriteShowAction $action)
    {
        return $action($windNote);
    }

    public function update(WindNote $windNote, NoteFavoriteUpdateAction $action)
    {
        return $action($windNote);
    }
}
