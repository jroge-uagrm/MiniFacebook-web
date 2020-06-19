<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Friend;
use App\FriendRequest;
use Auth;
use Carbon\Carbon;

class FriendRequestController extends Controller
{
    public function allMine(){
        $friendRequests=FriendRequest::where([
            ['requested',Auth::user()->id]
        ])->join('users','requesting','users.id')
        ->select(
            'id',
            'names',
            'paternal_surname',
            'maternal_surname',
        )->get();
        return redirect()->back()->with(
            'friendRequests',
            $friendRequests
        );
    }

    public function accept($userId){
        if(FriendRequest::where([
            ['requesting',$userId],
            ['requested',Auth::user()->id]
        ])->delete()){
            $friend=new Friend();
            $friend->sender=$userId;
            $friend->receiver=Auth::user()->id;
            $friend->created_at=Carbon::now();
            $friend->save();
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
}
