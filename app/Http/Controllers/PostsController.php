<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memes;

class PostsController extends Controller
{
    public function getPosts() {
        // return response()->json(Memes::all(), 200);
        $postsResponse = response()->json(Memes::all(), 200);
        $pos = $postsResponse->getData();
        foreach ($pos as $key => $value) {
            var_dump($key, $value);
        }
    }

    public function getPostById($id) {
        $post = Memes::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'post not found'], 404);
        }
        return response()->json($post::find($id), 200);
    }

    public function addBlogPost(Request $request) {
        $post = Memes::create($request->all());
        return response()->json($post, 201);
    }

    public function updateBlogPost(Request $request, $id) {
        $post = Memes::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'post not found'], 404);
        }
        $post->update($request->all());
        return response($post, 200);
    }

    public function deleteBlogPost(Request $request, $id) {
        $post = Memes::find($id);
        if (is_null($post)) {
            return response()->json(['message' => 'post not found'], 404);
        }
        $post->delete();
        return response()->json(null, 204);
    }

}
