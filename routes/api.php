<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('post', 'PostController@allPosts');
Route::get('post/{id}/', 'PostController@showPost');
Route::get('post/tag/{id}', 'PostController@postsTag');

Route::get('tag', 'TagController@allTag');
Route::get('tag/{id}/', 'TagController@showTag');

Route::get('storage/image_post/{filename}', function ($filename)
{
    return Storage::disk('local')->get('image_post/' . $filename);
});

Route::group(['middleware' => 'jwt.valid'], function () {
    
    Route::get('current_user', 'UserController@getAuthenticatedUser');

    Route::post('post', 'PostController@addPost');
    Route::put('post/{id}/', 'PostController@updatePost');
    Route::delete('post/{id}/', 'PostController@deletePost');


    
    Route::post('tag', 'TagController@addTag');
    Route::put('tag/{id}/', 'TagController@updateTag');
    Route::delete('tag/{id}/', 'TagController@deleteTag');

});

