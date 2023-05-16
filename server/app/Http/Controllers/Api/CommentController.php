<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Comment\CommentCollection;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $comments = Comment::with('user')->get();
       return new CommentCollection($comments);
        
    }

    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'comment'=>'required',
            'post_id'=>'required',
        ]);
        $comment=Comment::create([
            'comment'=>$request->input('comment'),
            'user_id'=>auth()->user()->id, 
            'post_id'=>$request->input('post_id'),
        ]);
        return response()->json([
            'message'=>'comment added seccessfully',
            'comment'=>$comment,
            // 'user'=>$comment->user
        ]);
    }

  
    
    public function show( $id)
    {
        $comment=Comment::find($id);
        if($comment){
              return new CommentResource($comment);
        }else{
            return response()->json([
                'error'=>"Comment Not Found"
            ]);
        }
    }
    
    
    
    public function update(Request $request, Comment $comment)
    {
        $this->validate($request,[
            'comment'=>'required',
            'post_id'=>'required',
        ]);
        $comment->update([
            'comment'=>$request->input('comment'),
            'user_id'=>auth()->user()->id, 
            'post_id'=>$request->input('post_id'),
        ]);
        return response()->json([
            'message'=>'comment updated seccessfully',
            'comment'=>$comment,
            // 'user'=>$comment->user
        ]);
    }
 
   
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'comment'=>$comment
        ]);
    }

    


    
}
