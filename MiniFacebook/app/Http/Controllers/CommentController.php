<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Carbon\Carbon;
use Auth;

class CommentController extends Controller
{
    public function create(Request $request){
        $comment=new Comment();
        $comment->content=$request->content;
        $comment->user_id=Auth::id();
        $comment->publication_id=$request->publication_id;
        $comment->created_at=Carbon::now();
        $comment->save();
        return redirect()->back();
    }
}
