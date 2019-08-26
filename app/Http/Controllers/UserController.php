<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function current()
    {
        $user = auth()->user();

        return response()->json(['user' => $user]);
    }
}
