<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     public function index()
    {
     
        return response()->json([
            'user' => Auth::user(),
            'message'=>'Success'
        ]);
        
    }
    public function count()
    {
        $userCount = User::count();
        return response()->json([
            'count' => $userCount,
            'message' => 'User count retrieved successfully'
        ]);
    }
}
