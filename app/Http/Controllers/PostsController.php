<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Post;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct() /** auth middleware */
    {
        $this->middleware('auth');
    }

    public function index()
    {

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

        return redirect('/profile/' . auth()->user()->username);
    }

    public function show(Post $post)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains('user_id', $post->user->id) : false;

        return view('posts.show',[
            'post' => $post,
            'follows' => $follows
        ]);
    }
}
