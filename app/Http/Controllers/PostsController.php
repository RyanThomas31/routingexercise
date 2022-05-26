<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memes;

class PostsController extends Controller
{
    public function getPosts() {
        // return response()->json(Memes::all(), 200);
        $postsResponse = response()->json(Memes::all(), 200);
        return $postsResponse;
    }

    public function getPostById($id) {
        $post = Memes::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'post not found'], 404);
        }
        return response()->json($post, 200);
    }

    public function createPost(Request $request) {
        $post = Memes::create($request->all());
        return response()->json($post, 201);
    }

    public function updatePost(Request $request, $id) {
        $post = Memes::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'post not found'], 404);
        }
        $post->update($request->all());
        return response($post, 200);
    }

    public function deletePost(Request $request, $id) {
        $post = Memes::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'post not found'], 404);
        }
        $post->delete();
        return response()->json(null, 204);
    }

}
