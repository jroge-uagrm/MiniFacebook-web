<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Contact;
use App\FriendRequest;
use App\Publication;
use Auth;
use Image;
use Exception;

class UserController extends Controller
{
    public function index($userId){
        $user=User::find($userId);
        $user->birthday=Carbon::parse($user->birthday)->locale('es_ES')->isoFormat('D [de] MMMM');
        $isFriend=Contact::where([
            ['user_a',Auth::user()->id],
            ['user_b',$user->id]
        ])->orWhere([
            ['user_b',Auth::user()->id],
            ['user_a',$user->id]
        ])->first()!=null;
        $availableToSendFriendRequest=FriendRequest::where([
            ['requested',Auth::user()->id],
            ['requesting',$user->id]
        ])->orWhere([
            ['requesting',Auth::user()->id],
            ['requested',$user->id]
        ])->first()==null;
        $publications=Publication::where('user_id',$user->id)->orderBy('created_at','desc')->get();
        return view('user.index',compact(
            'user',
            'isFriend',
            'availableToSendFriendRequest',
            'publications'
        ));
    }

    public function profilePicture($userId){
        $user=User::find($userId);
        $profilePicturePath=$user->profile_picture_path;
        try{
            return Image::make(public_path(). $profilePicturePath)->response('jpeg');
        }catch(Exception $e){
            return Image::make(public_path(). "/images/pp-default.jpeg")->response('jpeg');
        }
    }

    public function configurations(){
        return view('user.configurations');
    }

    public function update(Request $request){
        $request->validate([
            'names' => 'required|string',
            'last_names' => 'required|string',
            'birthday' => 'required|date',
            'email' => 'required|email',
            'color' => 'required',
            'font' => 'required',
        ]);
        if($request->phone_number){
            $request->validate([
                'phone_number' => 'numeric',
            ]);
        }
        $user=Auth::user();
        $user->names=$request->names;
        $user->last_names=$request->last_names;
        // $user->full_name=$request->names.' '.$request->last_names;
        $user->phone_number=$request->phone_number;
        $user->birthday=$request->birthday;
        $user->sex=$request->sex;
        $user->style=$request->color.$request->font;
        if($user->email!=$request->email){
            if(User::where('email',$request->email)->first()!=null){
                throw AuthController::newError('email','Correo ya registrado');
            }
            $user->email=$request->email;
        }
        $response="Se han actualizado tus datos.";
        try{
            if($request->hasFile('profile_picture')){
                $profile_picture=$request->profile_picture;
                $image=Image::make($profile_picture);
                $image->resize(300,300);
                $image->save(public_path()."/images/pp-$user->id.jpeg");
                $user->profile_picture_path="/images/pp-$user->id.jpeg";
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
}
