<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function __construct() /** auth middleware */
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        $url = url()->previous();

        auth()->user()->following()->toggle($user->profile);

        return redirect($url);
    }
}
