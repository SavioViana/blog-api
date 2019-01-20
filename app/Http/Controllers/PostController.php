<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Requests\PostValidation;
use App\User;
use App\Post;

class PostController extends Controller
{
    private $user; 
    private $post;

    public function __construct(User $user, Post $post)
    {
        $this->user = $user;
        $this->post = $post;
    }

    /*
    * Method return all posts this blog
    */
    public function index()
    {   
        $posts = $this->post->all();
        
        foreach ($posts as $key => $p) {
            $p->tags = $p->tags()->get();
            $p->author = $p->author()->get();
            $p->comments = $p->comments()->get();
        }
    
        return Response::json([
            'success' => true,
            'length' => count($posts),
            'data' => $posts,
        ], 200);
    }
    
    /**
     * Method insert one post in blog api
     */
    public function store(PostValidation $request)
    {    
        $post = new Post();
        $post->user_id = Auth()->user()->id;
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->published = $request->published;
        
        if ($request->file('image')) {
            $path = $request->file('image')->store('image_post');
            $post->image = $path;
        }
        
        if ($post->save()) {
            $post->tags()->sync($request->tags);
            $post->tags = $post->tags()->get();
            $tags = array();

            return Response::json([
                'success' => true,
                'message' => 'Created post',
                'data' => $post,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Sorry, product could not be added'
        ], 400);
    }

    /**
     * Method update one post this blog
     */
    public function update(PostValidation $request, int $id)
    {
        if (!$id) {
            return Response::json(['response' => 'Invalid id'], 400);
        }

        $post = $this->post->find($id);

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->published = $request->published;

        
        if ($request->file('image')) {
            $path = $request->file('image')->store('image_post');
            $post->image = $path;
        }

        if ($post->save()) {
            $post->tags()->detach();
            $post->tags()->sync($request->tags);
            $post->tags = $post->tags()->get();
            return Response::json([
                'success' => true,
                'message' => 'Updated post',
                'data' => $post,
            ], 200);
        
        }

        return Response::json([
            'success' => false,
            'message' => 'Invalid data',
        ], 400);

    }

    /**
     * Method return one specific post this blog
     */
    public function show(int $id)
    {
        $post = $this->post->find($id);
        
        if ($post) {
            $post->author = $post->author()->get();
            $post->tags = $post->tags()->get();
            $post->comments = $post->comments()->get();

            return Response::json([
                'success' => true,
                'data' => $post,
            ], 200);
        }
        
        return Response::json([
            'success' => false,
            'message' => 'Invalid post',
        ], 400);
    }

    /**
     * Method remove one specific post this blog
     */
    public function destroy(int $id)
    {
        $post = $this->post->find($id);

        if ($post) {

            $post->delete();

            return Response::json([
                'success' => true,
                'message' => 'Deleted post',
                'data' => $post,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Invalid post',
        ], 400);
    }
    
}
