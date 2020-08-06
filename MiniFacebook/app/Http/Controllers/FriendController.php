<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use App\FriendRequest;
use Carbon\Carbon;
use Auth;

class FriendController extends Controller
{
    public function request($userId){
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

    public function delete($userId){
        Friend::where([
            ['sender',Auth::user()->id],
            ['receiver',$userId]
        ])->orWhere([
            ['receiver',Auth::user()->id],
            ['sender',$userId]
        ])->delete();
        return redirect()->back()->with(
            'success',
            'Se ha eliminado.'
        );
    }
}
