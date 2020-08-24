<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\FriendRequest;
use Auth;
use Carbon\Carbon;
use App\Events\FriendRequestSent;
use App\Events\FriendRequestAccepted;
use DB;


class FriendRequestController extends Controller
{
    public function send($userId){
        if($userId===Auth::id()){
            return redirect()->back()->with(
                'error',
                'No puedes enviarte solicitud a ti mismo.'
            );
        }
        $availableToSendFriendRequest=FriendRequest::where([
            ['requested',Auth::user()->id],
            ['requesting',$userId]
        ])->orWhere([
            ['requesting',Auth::user()->id],
            ['requested',$userId]
        ])->first()==null;
        if($availableToSendFriendRequest){
            $friendRequest=new FriendRequest();
            $friendRequest->requesting=Auth::id();
            $friendRequest->requested=$userId;
            $friendRequest->created_at=Carbon::now();
            $friendRequest->save();
            $data=[
                "userId"=>$userId
            ];
            event(new FriendRequestSent($data));
            return redirect()->back()->with(
                'success',
                'Solicitud enviada.'
            );
        }else{
            return redirect()->back()->with(
                'error',
                'No se ha podido enviar la solicitud.'
            );
        }
    }

    public function allMine(){
        $friendRequests=FriendRequest::where([
            ['requested',Auth::user()->id]
        ])->join('users','requesting','users.id')
        ->select(
            'users.id',
            'names',
            'last_names'
        )->get();
        return redirect()->back()->with(
            'friendRequests',
            $friendRequests
        );
    }

    public function allSent(){
        $friendRequests=FriendRequest::where([
            ['requesting',Auth::user()->id]
        ])->join('users','requested','users.id')
        ->select(
            'users.id',
            'names',
            'last_names'
        )->get();
        return view('friendRequest.index',compact('friendRequests'));
    }

    public function accept($userId){
        if(FriendRequest::where([
            ['requesting',$userId],
            ['requested',Auth::user()->id]
        ])->delete()){
            /* $contact=new Contact();
            $contact->user_a=$userId;
            $contact->user_b=Auth::user()->id;
            $contact->created_at=Carbon::now();
            $contact->save();
            $contact=new Contact();
            $contact->user_b=$userId;
            $contact->user_a=Auth::user()->id;
            $contact->created_at=Carbon::now();
            $contact->save(); */
            DB::table('contacts')->insert([[
                'user_a' => $userId,
                'user_b' => Auth::user()->id
            ]]);
            DB::table('contacts')->insert([[
                'user_a' => Auth::user()->id,
                'user_b' => $userId
            ]]);
            $data=[
                'sender'=>Auth::id(),
                'names'=>Auth::user()->names,
                'receiverId'=>$userId
            ];
            event(new FriendRequestAccepted($data));
            return redirect()->back()->with(
                'success',
                'Amigo aceptado.'
            );
        }else{
            return redirect()->back()->with(
                'error',
                'No existe la solicitud.'
            );
        }
    }
    
    public function reject($userId){
        if(FriendRequest::where([
            ['requesting',$userId],
            ['requested',Auth::user()->id]
        ])->delete()){
            return redirect()->back()->with(
                'success',
                'Amigo rechazado.'
            );
        }else{
            return redirect()->back()->with(
                'error',
                'No existe la solicitud.'
            );
        }
    }

    public function delete($userId){
        if(FriendRequest::where([
            ['requesting',Auth::id()],
            ['requested',$userId],
        ])->delete()){
            return redirect()->back()->with(
                'success',
                'Solicitud eliminada correctamente.'
            );
        }else{
            return redirect()->back()->with(
                'error',
                'No existe la solicitud.'
            );
        }
    }
}
