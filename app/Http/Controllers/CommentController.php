<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\CommentsValidation;

class CommentController extends Controller
{
    private $comment; 
    
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function index()
    {
        $comments = $this->comment->all();

        return Response::json([
            'success' => true,
            'length' => $comments->count(),
            'data' => $comments,
        ], 200);  
    }

    public function store(CommentsValidation $request)
    {
        $comment = new Comment();
        $comment->description = $request->description; 
        $comment->post_id = $request->post_id; 
    
        if ($comment->save()) {
            return Response::json([
                'success' => true,
                'message' => 'Created comment',
                'data' => $comment,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Sorry, comment could not be added'
        ], 400);
    }

    public function update(CommentsValidation $request, int $id)
    {
        if (!$id) {
            return Response::json(['response' => 'Invalid id'], 400);
        }

        $comment = $this->comment->find($id);
        $comment->description = $request->description; 
        $comment->post_id = $request->post_id; 
    
        if ($comment->save()) {
            return Response::json([
                'success' => true,
                'message' => 'Updated comment',
                'data' => $comment,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Sorry, comment could not be updated'
        ], 400);
    }

    public function show(int $id)
    {
        $comment = $this->comment->find($id);

        if ($comment) {
            return Response::json([
                'success' => true,
                'data' => $comment,
            ], 200);
        } 

        return Response::json([
            'success' => false,
            'message' => 'Invalid comment',
        ], 400);
    }

    public function destroy(int $id)
    {
        $comment = $this->comment->find($id);

        if ($comment) {

            $comment->delete();

            return Response::json([
                'success' => true,
                'message' => 'Deleted comment',
                'data' => $comment,
            ], 200);
        }

        return Response::json([
            'success' => false,
            'message' => 'Invalid comment',
        ], 400);
    }
}
