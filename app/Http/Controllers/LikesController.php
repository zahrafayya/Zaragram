<?php

namespace App\Http\Controllers;

use App\Models\Post;
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
}
