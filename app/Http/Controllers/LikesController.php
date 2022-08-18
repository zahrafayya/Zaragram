<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function __construct() /** auth middleware */
    {
        $this->middleware('auth');
    }

    public function store(Post $post)
    {
        $url = url()->previous();

        auth()->user()->likes()->toggle($post);

        return redirect($url);
    }

    public function get_likes(Post $post)
    {
        $liked = $post->liked()->pluck('user_id');

        $usr_liked = User::whereIn('id', $liked)->get();

        return view('posts.liked', compact('usr_liked'));
    }
}
