<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Carbon\Carbon;
use Auth;

class CommentController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'content' => 'required',
        ]);
        $comment=new Comment();
        $comment->content=$request->content;
        $comment->user_id=Auth::id();
        $comment->publication_id=$request->publication_id;
        $comment->created_at=Carbon::now();
        $comment->save();
        return redirect()->back();
    }

    public function delete($commentId){
        if(Comment::where('id',$commentId)->delete()){
            return redirect()->back()->with(
                'success',
                'Borrado correctamente'
            );
        }
    }

    public function edit(Request $request){
        $request->validate([
            'content' => 'required'
        ]);
        $commentId=$request->comment_id;
        $comment=Comment::find($commentId);
        $comment->content=$request->content;
        $comment->save();
        return redirect()->back()->with(
            'success',
            'Comentario actualizado.'
        );
    }
}
