<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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

        $this->authorize('update', $obj->profile);

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
            'url' => ['url', 'nullable']
        ]);

        if (request('image')) // do something special if the request have 'image'
        {
            $imagePath = request('image')->store('profpics', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            auth()->user()->profile->update(array_merge(
                $data,
                ['image' => $imagePath],
            ));
        }
        else
        {
            auth()->user()->profile->update($data);
        }

        return redirect('/profile/' . auth()->user()->username);
    }

}
