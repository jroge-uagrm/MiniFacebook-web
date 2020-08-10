<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publication;
use App\Comment;
use Auth;
use App\Contact;
use DB;

class PublicationController extends Controller
{
    public function index($publicationId){
        $publication=DB::table('users')
        ->join('publications','publications.user_id','users.id')
        ->where('publications.id',$publicationId)
        ->first();
        $comments=DB::table('users')
        ->join('comments','comments.user_id','users.id')
        ->where('comments.publication_id',$publication->id)
        ->get();
        return view('publication.index',compact('publication','comments'));
    }

    public function create(Request $request){
        $request->validate([
            'content' => 'required'
        ]);
        $publication=new Publication();
        $publication->content=$request->content;
        $publication->user_id=Auth::id();
        $publication->save();
        return redirect()->back();
    }
}
