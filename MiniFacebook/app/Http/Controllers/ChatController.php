<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Chat;
use App\Message;
use App\Contact;
use Auth;
use App\Events\NewMessage;
use Carbon\Carbon;
use DB;

class ChatController extends Controller
{
    public function index($userId,$chat_lenght=10){
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
            $messages=Message::where('chat_id',$chat->id)
            ->orderBy('created_at','desc')
            ->take($chat_lenght)
            ->get();
            $messages=array_reverse($messages->toArray());
        }
        return view('home.chat',compact('user','messages'));
    }

    public function allMine(){
        $chatsCreator=Chat::where('creator',Auth::id())
        ->join('users','users.id','invited')
        ->join('messages','messages.chat_id','chats.id')
        ->join('contacts','contacts.user_b','chats.invited')
        ->select(
            'users.id',
            'users.names',
            'users.last_names',
            'chats.updated_at',
        );
        $chats=Chat::where('invited',Auth::id())
        ->join('users','users.id','creator')
        ->join('messages','messages.chat_id','chats.id')
        ->join('contacts','contacts.user_b','chats.creator')
        ->select(
            'users.id',
            'users.names',
            'users.last_names',
            'chats.updated_at',
        )->union($chatsCreator)->get();
        return redirect()->back()->with(
            'chats',
            $chats
        );
    }

    public function sendMessage(Request $request){
        $text=[
            'senderId'=>Auth::id(),
            'receiverId'=>$request->receiverId,
            'content'=>$request->content,
            'names'=>Auth::user()->names,
        ];
        if(Contact::where([
            ['user_a',Auth::id()],
            ['user_b',$request->receiverId],
        ])->first()!=null){
            $chat=Chat::where([
                ['creator',Auth::id()],
                ['invited',$request->receiverId],
            ])->orWhere([
                ['invited',Auth::id()],
                ['creator',$request->receiverId],
            ])->first();
            if($chat==null){
                $chat=new Chat();
                $chat->messages_amount=0;
                $chat->creator=Auth::id();
                $chat->invited=$request->receiverId;
                $chat->created_at=Carbon::now();
                $chat->save();
            }
            $message=new Message();
            $message->sender=Auth::id();
            $message->receiver=$request->receiverId;
            $message->content=$request->content;
            $message->chat_id=$chat->id;
            $message->created_at=Carbon::now();
            $message->save();
            $chat->messages_amount=$chat->messages_amount+1;
            $chat->updated_at=Carbon::now();
            $chat->save();
            event(new NewMessage($text));
        }
        return redirect()->back();
    }
}
