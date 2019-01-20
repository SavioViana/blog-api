<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\TagValidation;
use \App\Tag;

class TagController extends Controller
{
    private $tag;

    public function __construct(Tag $tag)
    {   
        $this->tag = $tag;
    }

    public function index()
    {   
        $tags = $this->tag->all();

        return Response::json([
            'success' => true,
            'length' => count($tags),
            'data' => $tags,
        ], 200);
    }

    public function store(TagValidation $request)
    {   
        $tag = new Tag();
        $tag->name = $request->name;

        if ($tag->save()) {
            return Response::json([
                'success' => true,
                'message' => 'Created tag',
                'data' => $tag,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Sorry, tag could not be added'
        ], 400);
    }

    public function update(TagValidation $request, int $id )
    {
        if (!$id) {
            return Response::json([
                'success' => false,
                'message' => 'Sorry, Invalid id'
            ], 400);
        }

        $tag = $this->tag->find($id);
        $tag->name = $request->name;
        
        if ($tag->save()) {
            return Response::json([
                'success' => true,
                'message' => 'Updated tag',
                'data' => $tag,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Sorry, tag could not be updated'
        ], 400);
    }

    public function show(int $id)
    {
        $tag = $this->tag->find($id);

        if ($tag) {
            return Response::json([
                'success' => true,
                'data' => $tag,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Invalid tag',
        ], 400);
    }

    public function destroy(int $id)
    {
        $tag = $this->tag->find($id);

        if ($tag->delete()) {
            return Response::json([
                'success' => true,
                'message' => 'Deleted tag',
                'data' => $tag,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Invalid tag',
        ], 400);
    }

    public function posts(int $id)
    {
        $tag = $this->tag->find($id);

        if ($tag) {

            $tag->posts = $tag->posts()->get();
            foreach ($tag->posts as $key => $post) {
                $post->author = $post->author()->get();
                $post->comments = $post->comments()->get();
            }
            return Response::json([
                'success' => true,
                'length' => $tag->posts->count(),
                'data' => $tag,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Invalid Tag',
        ], 200);
    }

}
