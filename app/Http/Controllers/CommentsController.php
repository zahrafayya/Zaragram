<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CommentsController extends Controller
{
    public function __construct() /** auth middleware */
    {
        $this->middleware('auth');
    }

    public function store(Post $post)
    {
        $data = request()->validate([
            'comment' => 'required'
        ]);

        auth()->user()->comments()->create([
            'post_id' => $post->id,
            'comment' => $data['comment']
        ]);

        return redirect('/p/' . $post->id);
    }

    public function destroy(Comment $comment)
    {
        $url = url()->previous();

        $comment->delete();

        return redirect($url);
    }
}
