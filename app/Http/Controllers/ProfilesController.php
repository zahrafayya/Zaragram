<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index($user)
    {
        $id = User::select('id')->where('username', $user)->first();

        if(is_null($id))
        {
            dd("error");
        }
        else
        {
            return view('home', [
                'user' => $user,
            ]);
        }
    }
}
