<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show($username)
    {
        $id = User::select('id')->where('username', $username)->first();
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

    public function edit($user)
    {
        $obj = User::findOrFail($user)->first();
        return view('profiles.edit', [
            'user' => $obj,
        ]);
    }

    public function update($user)
    {
        $data = request()->validate([
            'image' => 'image',
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',

        ]);

        $obj = User::findOrFail($user)->first();
        $obj->profile->update($data);

        return redirect('/profile/' . auth()->user()->username);
    }

}
