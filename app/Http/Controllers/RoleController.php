<?php

namespace App\Http\Controllers;

use App\Models\User;

class RoleController extends Controller
{
    /**
     * Get all available roles
     */
    public function index()
    {
        return response()->json([
            'data' => User::getAvailableRoles(),
        ]);
    }
}
