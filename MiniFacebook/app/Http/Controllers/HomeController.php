<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Exception;
use App\User;
use App\Friend;
use App\FriendRequest;
use Image;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index($contentType="publications",$userId=1){
        $isFriend=$user="";
        switch ($contentType) {
            case "publications":
                $publications=[
                    "publication A",
                    "Publication B",
                    "Publication C",
                    "Publication D",
                ];
                break;
            case "configurations":
                $configurations="";
                break;
            case "profile":
                $profile="";
                $user=User::find($userId);
                $user->birthday=Carbon::parse($user->birthday)->locale('es_ES')->isoFormat('D [de] MMMM');
                $isFriend=Friend::where([
                    ['sender',Auth::user()->id],
                    ['receiver',$user->id]
                ])->orWhere([
                    ['receiver',Auth::user()->id],
                    ['sender',$user->id]
                ])->first()!=null;
                break;
        }
        $friendRequests=FriendRequest::where([
            ['requested',Auth::user()->id]
        ])->join('users','requesting','users.id')
        ->select(
            'id',
            'names',
            'paternal_surname',
            'maternal_surname',
        )->get();
        return view('home.'.$contentType,compact(
            'contentType',
            $contentType,
            'friendRequests',
            'isFriend',
            'user'
        ));
    }

    public function profile($userId){
        return $this->index("profile",$userId);
    }

    public function configurations(){
        return $this->index("configurations");
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
        try{
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
                    $user->profile_picture=$image;
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
        }catch(Exception $e){
            // throw AuthController::newError("email","Este correo ya ha sido registrado.");
            throw AuthController::newError("email",$e->getMessage());
        }
    }

    public function fetch_image($userId){
        $user=User::find($userId);
        $image_file=Image::make($user->profile_picture);
        $response=Response::make($image_file->encode('jpeg'));
        $response->header('Content-Type','image/jpeg');
        return $response;
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
}
