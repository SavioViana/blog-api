<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use \App\Tag;
use Validator;


class TagController extends Controller
{
    
    public function __construct()
    {   
    }

    public function allTag(Tag $tag)
    {   
        $tags = $tag->all();

        return Response::json([
            'success' => true,
            'length' => count($tags),
            'data' => $tags,
        ], 200);
    }

    public function addTag(Request $request)
    {   
        $validateTag = Validator::make($request->all(), [
            'name'    => 'required|max:45|min:4',
        ]);

        if($validateTag->fails())
        {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data',
                'errors' => $validateTag->errors(),
            ], 400);
        }

        $tag = new Tag();
        $tag->name = $request->name;

        if($tag->save())
        {
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

    public function updateTag(Request $request, int $tagId )
    {
        if (!$tagId) {
            return Response::json([
                'success' => false,
                'message' => 'Sorry, Invalid id'
            ], 400);
        }

        $validateTag = Validator::make($request->all(), [
            'name'    => 'required|max:45|min:4',
        ]);

        if($validateTag->fails())
        {
            return Response::json([
                'success' => false,
                'message' => 'Invalid data',
                'errors' => $validateTag->errors(),
            ], 400);
        }

        $tag = Tag::find($tagId);
        $tag->name = $request->name;
        
        if($tag->save())
        {
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

    public function showTag(Tag $tag, int $tagId)
    {
        $tag = $tag->find($tagId);

        if($tag)
        {
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

    public function deleteTag(Tag $tag, int $tagId)
    {
        $tag = $tag->find($tagId);

        if($tag->delete())
        {
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

}
