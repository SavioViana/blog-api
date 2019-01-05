<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;


class PostController extends Controller
{
    

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function allPosts(Post $post)
    {   
        $posts = $post->all();

        foreach ($posts as $key => $p) {
            $p->tags = $post->getTagsPost($p->id);
        }
    
        return $posts;
    }

    public function addPost(Request $request)
    {   
        
        $post = new Post();
        $post->author_id = 1;
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->body = $request->input('body');
        $post->image = $request->input('image');
        $post->published = $request->input('published');

        
        if($post->save())
        {

            $tags = array();
            foreach ($request->input('tags') as $key => $tagId) 
            {
                $postTag = new PostTag();
                $postTag->post_id = $post->id;
                $postTag->tag_id = $tagId;

                $postTag->save();

                $tags[] = $postTag;
            }

            $post->tags = array_values($tags);

            return Response::json($post, 200);
        }

        return Response::json(['response' => 'Invalid data'], 400);

    }

    public function updatePost(Request $request, int $postId )
    {
        
        if (!$postId) {
            return Response::json(['response' => 'Invalid id'], 400);
        }

        $post = Post::find($postId);
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->body = $request->input('body');
        $post->image = $request->input('image');
        $post->published = false;

        if($post->save())
        {

            $postTags = PostTag::where('post_id', $post->id)->get();
        
            if ($postTags)
            {
                foreach ($postTags as $key => $postTag) {
                   
                    $postTag->delete();
                }
            }
            

            $tags = array();
            foreach ($request->input('tags') as $key => $tagId) 
            {
                $postTag = new PostTag();
                $postTag->post_id = $post->id;
                $postTag->tag_id = $tagId;

                $postTag->save();

                $tags[] = $postTag;
            }

            $post->tags = array_values($tags);

            return Response::json($post, 200);
        }

        return Response::json(['response' => 'Invalid data'], 400);

    }

    public function showPost(Post $post, int $postId)
    {
        $post = $post->find($postId);
        $post->tags = $post->getTagsPost($post->id);
    

        if($post)
        {
            return Response::json($post, 200);
        }

        return Response::json(['response' => 'Invalid post'], 400);
    }

    public function deletePost(Post $post, int $postId)
    {
        $post = $post->find($postId);

        if($post->delete())
        {
            return Response::json(
                [
                    'response' => [
                        'message' => 'post deleted',
                        'post' => $post
                    ]
                ], 200);
        }

        return Response::json(['response' => 'Invalid post'], 400);
    }

}
