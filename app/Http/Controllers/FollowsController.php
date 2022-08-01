<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function store(User $user)
    {
        auth()->user()->following()->toggle($user->profile);

        return redirect('/profile/' . $user->username);
    }
}
