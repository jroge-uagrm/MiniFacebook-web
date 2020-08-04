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

    public function profile($userId){
        $user=User::find($userId);
                $user->birthday=Carbon::parse($user->birthday)->locale('es_ES')->isoFormat('D [de] MMMM');
                $isFriend=Friend::where([
                    ['sender',Auth::user()->id],
                    ['receiver',$user->id]
                ])->orWhere([
                    ['receiver',Auth::user()->id],
                    ['sender',$user->id]
                ])->first()!=null;
        return view('home.profile',compact('user','isFriend'));
    }

    public function configurations(){
        return view('home.configurations');
    }

    public function update(Request $request){
        $request->validate([
            'names' => 'required',
            'paternal_surname' => 'required',
            'maternal_surname' => 'required',
            'birthday' => 'required|date',
            'email' => 'required|email',
        ]);
        $user=Auth::user();
        $user->names=$request->names;
        $user->paternal_surname=$request->paternal_surname;
        $user->maternal_surname=$request->maternal_surname;
        $user->full_name=$request->names.' '.$request->paternal_surname.' '.$request->maternal_surname;
        $user->birthday=$request->birthday;
        $user->email=$request->email;
        $response="Se han actualizado tus datos.";
        try{
            if($request->hasFile('profile_picture')){
                $profile_picture=$request->profile_picture;
                $image=Image::make($profile_picture);
                $image->resize(300,300);
                Response::make($image->encode('jpeg'));
                $image->save(public_path()."/images/pp-$user->id.jpeg");
                // $user->profile_picture_path='public/images/pp-'.$user->id.'.jpeg';
                $response="Se ha guardado tu nueva foto de perfil.";
            }
        }catch(Exception $e){
            throw AuthController::newError("profile_picture","Tipo de archivo no soportado.");
        }
        $user->save();
        return redirect()->back()->with(
            'success',
            $response
        );
    }

    public function profilePicture($userId){
        try{
            // return response()->file(public_path(). "/images/pp-'.$userId.'.jpeg");
            return Image::make(public_path(). "/images/pp-$userId.jpeg")->response('jpeg');
        }catch(Exception $e){
            // return response()->file(public_path(). "/images/pp-default.jpeg");
            return Image::make(public_path(). "/images/pp-default.jpeg")->response('jpeg');
        }
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
            'users.paternal_surname',
            'users.maternal_surname',
        );

        $chats=Chat::where('invited',Auth::user()->id)
        ->join('users','users.id','creator')
        ->join('messages','messages.chat_id','chats.id')
        ->select(
            'users.id',
            'users.names',
            'users.paternal_surname',
            'users.maternal_surname',
        )->union($chatsCreator)->get();

        return redirect()->back()->with(
            'chats',
            $chats
        );
    }
}
