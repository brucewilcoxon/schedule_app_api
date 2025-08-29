<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Get all available roles
     */
    public function index()
    {
        return response()->json([
            'data' => User::getAvailableRoles()
        ]);
    }
} 