<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(5);
        return response()->json([
            'status' => false,
            'data' => [
                'user' => new UserCollection($users)
            ]
        ], 200);
    }
}
