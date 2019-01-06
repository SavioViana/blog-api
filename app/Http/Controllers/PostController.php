<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\PostTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Validator;
use App\User;


class PostController extends Controller
{
    

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /*
    * Method return all posts this blog
    */
    public function allPosts(Post $post)
    {   
        $posts = $post->all();

        foreach ($posts as $key => $p)
        {
            $p->tags = $post->getTagsPost($p->id);
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
    public function addPost(Request $request)
    {   
        
        $validatePost = Validator::make($request->all(), [
            'title'    => 'required|max:100|min:3',
            'slug'     => 'required|max:100|min:3',
            'body'     => 'required|min:5',
            'image'    => 'required|max:100',
            'published' => 'required|boolean',
            'tags'     => 'required',
        ]);
        
        if($validatePost->fails())
        {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data',
                'errors' => $validatePost->errors(),
            ], 400);
        }

        
        $post = new Post();
        $post->user_id = $this->user->userAuthId();
        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->body = $request->body;
        $post->image = $request->image;
        $post->published = $request->published;
    
        if($post->save())
        {
            $tags = array();
            foreach ($request->tags as $key => $tagId) 
            {
                $postTag = new PostTag();
                $postTag->post_id = $post->id;
                $postTag->tag_id = $tagId;

                $postTag->save();

                $tags[] = $postTag;
            }

            $post->tags = array_values($tags);

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
    public function updatePost(Request $request, int $postId )
    {
        //return $request;
        if (!$postId) {
            return Response::json(['response' => 'Invalid id'], 400);
        }

        $validatePost = Validator::make($request->all(), [
            'title'    => 'required|max:100|min:3',
            'slug'     => 'required|max:100|min:3',
            'body'     => 'required|min:5',
            'image'    => 'required|max:100',
            'published' => 'required|boolean',
            'tags'    => 'required',
        ]);
        
        if($validatePost->fails())
        {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data',
                'errors' => $validatePost->errors(),
            ], 400);
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
    public function showPost(Post $post, int $postId)
    {
        $post = $post->find($postId);
        
        if($post)
        {
            $post->tags = $post->getTagsPost($post->id);

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
    public function deletePost(Post $post, int $postId)
    {
        $post = $post->find($postId);

        if($post)
        {
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
