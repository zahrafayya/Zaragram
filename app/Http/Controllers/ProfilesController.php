<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show($user)
    {
        $id = User::select('id')->where('username', $user)->first();
        $obj = User::findOrFail($id)->first();

        if(is_null($id))
        {
            dd("error");
        }
        else
        {
            return view('profiles.show', [
                'user' => $obj,
            ]);
        }
    }
}
