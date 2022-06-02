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

Route::group(['prefix'=>'posts'], function(){
    //Get all Posts
    Route::get('/', [PostsController::class,'getPosts']);

    //Get Specific post
    Route::get('/{id}', [PostsController::class,'getPostById']);

    //Add new post
    Route::post('/create', [PostsController::class,'createPost']);

    //Update Post
    Route::put('/update/{id}', [PostsController::class,'updatePost']);

    //Delete Post
    Route::delete('/delete/{id}',[PostsController::class,'deletePost']);
});