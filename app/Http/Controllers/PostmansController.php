<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostmanRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostmansController extends Controller
{
    public function get($id = null)
    {
        if($id)
        {
            $post = Post::findOrFail($id);
        }
        else
        {
            $post = Post::get();
        }

        return response()->json([
            'success' => true,
            'message' => "Data Retrieved",
            'data' => $post
        ], 200);
    }

    public function store(PostmanRequest $request)
    {
        $post = Post::create($request->all());
        return response()->json([
            'success' => true,
            'message' => "Data Created",
            'data' => $post
        ], 201);
    }

    public function update($id, PostmanRequest $request)
    {
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return response()->json([
            'success' => true,
            'message' => "Data Updated",
            'data' => $post
        ], 200);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if($post)
        {
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => "Data Deleted",
            ], 200);
        }
        else
        {
            $post->delete();
            return response()->json([
                'success' => false,
                'message' => "Data Not Found",
            ], 404);
        }
    }
}
