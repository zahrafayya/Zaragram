<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function show($username)
    {
        $id = User::select('id')->where('username', $username)->first();
        $user = User::findOrFail($id)->first();

        $follows = (auth()->user()) ? auth()->user()->following->contains('user_id', $user->id) : false;

        $postCount = Cache::remember('count.post' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->posts->count();
        });

        $followersCount = Cache::remember('count.followers' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->profile->followers->count();
        });

        $followingCount = Cache::remember('count.following' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->following->count();
        });

        if(is_null($id))
        {
            dd("error");
        }
        else
        {
            return view('profiles.show', compact(
                'user',
                'follows',
                'postCount',
                'followersCount',
                'followingCount'
            ));
        }
    }

    public function edit($profile)
    {
        $user = Auth::user();

        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update($user)
    {
        dd("halo");
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
