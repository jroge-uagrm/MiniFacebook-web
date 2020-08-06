<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Exception;
use App\User;
use App\Friend;
use App\FriendRequest;
use App\Chat;
use App\Message;
use Image;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function publications(){
        $publications=[
            "publication A",
            "Publication B",
            "Publication C",
            "Publication D",
        ];
        return view('home.publications',compact('publications'));
    }

    public function search(Request $request){
        $request->validate([
            'fullName' => 'required',
        ]);
        $user=Auth::user();
        $foundUsers=User::where([
            ['full_name','like','%'.$request->fullName.'%'],
            ['id','<>',$user->id]
        ])->take(10)->get();
        return redirect()->back()->with(
            'foundUsers',
            $foundUsers
        );
    }

    public function chats(){
        $chatsCreator=Chat::where('creator',Auth::user()->id)
        ->join('users','users.id','invited')
        ->join('messages','messages.chat_id','chats.id')
        ->select(
            'users.id',
            'users.names',
            'users.last_names',
        );

        $chats=Chat::where('invited',Auth::user()->id)
        ->join('users','users.id','creator')
        ->join('messages','messages.chat_id','chats.id')
        ->select(
            'users.id',
            'users.names',
            'users.last_names',
        )->union($chatsCreator)->get();

        return redirect()->back()->with(
            'chats',
            $chats
        );
    }
}
