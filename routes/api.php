<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Get all Posts
Route::get('posts', [PostsController::class,'getPosts']);

//Get Specific post
Route::get('post/{id}', [PostsController::class,'getPostById']);

//Add new post
Route::post('addBlogs', [PostsController::class,'addBlogPost']);

//Update Post
Route::put('updatePost/{id}', [PostsController::class,'updateBlogPost']);

//Delete Post
Route::delete('deletePost/{id}',[PostsController::class,'deleteBlogPost']);