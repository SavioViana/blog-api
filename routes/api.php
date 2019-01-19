<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/*auth*/
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

/*posts*/
Route::get('posts', 'PostController@index');
Route::get('posts/{id}/', 'PostController@show');
Route::get('tags/{id}/posts/', 'TagController@posts');

/*comments*/
Route::get('comments', 'CommentController@index');
Route::get('comments/{id}', 'CommentController@show');
Route::post('comments', 'CommentController@store');

/* tag */
Route::get('tags', 'TagController@index');
Route::get('tags/{id}/', 'TagController@show');


Route::get('storage/image_post/{filename}', function ($filename)
{
    return Storage::disk('local')->get('image_post/' . $filename);
});


Route::group(['middleware' => 'jwt.valid'], function () {
    
    Route::get('current_user', 'UserController@getAuthenticatedUser');

    /*posts */
    Route::post('posts', 'PostController@store');
    Route::put('posts/{id}', 'PostController@update');
    Route::delete('posts/{id}/', 'PostController@destroy');

    
    /*tag */
    Route::post('tags', 'TagController@store');
    Route::put('tags/{id}/', 'TagController@update');
    Route::delete('tags/{id}/', 'TagController@destroy');

    /*comments*/
    Route::put('comments/{id}', 'CommentController@store');
    Route::delete('comments/{id}', 'CommentController@destroy');

});

