<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Chat;
use App\Message;
use Auth;

class ChatController extends Controller
{
    public function index($userId,$chat_lenght=5){
        $user=User::find($userId);
        $chat=Chat::where([
            ['creator',Auth::user()->id],
            ['invited',$userId]
        ])->orWhere([
            ['invited',Auth::user()->id],
            ['creator',$userId]
        ])->first();
        $messages=[];
        if($chat!=null){
            $messages=Message::where([
                ['chat_id',$chat->id],
                ['sender_status','saved']
                ])->orderBy('created_at','asc')->take($chat_lenght)->get();
        }
        return view('home.chat',compact('user','messages'));
    }
}
