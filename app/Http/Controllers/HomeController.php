<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Exception;
use App\User;
use App\Friend;
use App\FriendRequest;
use App\Chat;
use App\Contact;
use App\Message;
use Image;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use DB;
use Cache;

class HomeController extends Controller
{
    public function search(Request $request){
        $request->validate([
            'fullName' => 'required',
        ]);
        $user=Auth::user();
        $foundUsers=User::where([
            ['names','like','%'.$request->fullName.'%'],
            ['role_id','<>','3'],
        ])->orWhere([
            ['last_names','like','%'.$request->fullName.'%'],
            ['role_id','<>','3'],
        ])->get();
        return redirect()->back()->with(
            'foundUsers',
            $foundUsers
        );
    }

    public function index(){
        $publications=DB::table('contacts')
            ->where('user_a',Auth::id())
            ->join('users','users.id','contacts.user_b')
            ->join('publications','publications.user_id','users.id')
            ->orderBy('publications.created_at','desc')
            ->get();
        return view('home.publications',compact('publications'));
    }
}
