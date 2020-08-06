<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
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
            'users.id',
            'names',
            'last_names'
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
            $contact=new Contact();
            $contact->user_a=$userId;
            $contact->user_b=Auth::user()->id;
            $contact->created_at=Carbon::now();
            $contact->save();
            $contact=new Contact();
            $contact->user_b=$userId;
            $contact->user_a=Auth::user()->id;
            $contact->created_at=Carbon::now();
            $contact->save();
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
