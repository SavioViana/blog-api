<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use \App\Tag;



class TagController extends Controller
{
    

    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function allTag(Tag $tag)
    {   
        $tags = $tag->all();

        return $tags;
    }

    public function addTag(Request $request)
    {   
        $tag = new Tag();
        $tag->name = $request->input('name');
       

        if($tag->save())
        {
            return Response::json($tag, 200);
        }

        return Response::json(['response' => 'Invalid data'], 400);

    }

    public function updateTag(Request $request, int $tagId )
    {
        if (!$tagId) {
            return Response::json(['response' => 'Invalid id'], 400);
        }

        $tag = Tag::find($tagId);
        $tag->name = $request->input('name');
        
        if($tag->save())
        {
            return Response::json($tag, 200);
        }

        return Response::json(['response' => 'Invalid data'], 400);

    }

    public function showTag(Tag $tag, int $tagId)
    {
        $tag = $tag->find($tagId);

        if($tag)
        {
            return Response::json($tag, 200);
        }

        return Response::json(['response' => 'Invalid tag'], 400);
    }

    public function deleteTag(Tag $tag, int $tagId)
    {
        $tag = $tag->find($tagId);

        if($tag->delete())
        {
            return Response::json(
                [
                    'response' => [
                        'message' => 'Tag deleted',
                        'post' => $tag
                    ]
                ], 200);
        }

        return Response::json(['response' => 'Invalid tag'], 400);
    }

}
