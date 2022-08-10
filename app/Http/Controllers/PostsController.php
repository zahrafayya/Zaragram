<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct() /** auth middleware */
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id'); // ngambil user_id dari profile-profile yang kita follow
        $users->push(Auth::id());

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect('/');
    }

    public function show(Post $post)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains('user_id', $post->user->id) : false;

        return view('posts.show',[
            'post' => $post,
            'follows' => $follows
        ]);
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Post $post)
    {
        $data = request()->validate([
            'caption' => 'required'
        ]);

        $post->update($data);

        return redirect('/p/' . $post->id);
    }

    public function destroy(Post $post)
    {
        $url = URL::previous();

        $post->delete();

        if (str_contains($url, '/p/')) {
            return redirect('/profile/' . $post->user->username);
        }
        else return redirect('/');
    }
}
