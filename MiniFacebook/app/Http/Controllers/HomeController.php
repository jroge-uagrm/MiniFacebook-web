<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Exception;
use App\User;

use Image;
use Illuminate\Support\Facades\Response;

class HomeController extends Controller
{
    public function index(){
        $user = Auth::user();
        $contentType="publications";
        $publications=[
            "publication A",
            "Publication B",
            "Publication C",
            "Publication D",
        ];
        return view('home.index',compact('user','contentType','publications'));
    }

    public function read(){
        $user = Auth::user();
        $contentType="profile_config";
        return view('home.profile',compact('user','contentType'));
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
            $user->birthday=$request->birthday;
            $user->email=$request->email;
            $response="Se han actualizado tus datos.";
            if($request->hasFile('profile_picture')){
                $profile_picture=$request->profile_picture;
                $image=Image::make($profile_picture);
                Response::make($image->encode('jpeg'));
                $user->profile_picture=$image;
                $response="Se ha guardado tu nueva foto de perfil.";
            }
            $user->save();
            return redirect()->back()->with(
                'success',
                $response
            );
        }catch(Exception $e){
            throw AuthController::newError("email","Este correo ya ha sido registrado.");
        }
    }

    public function fetch_image($userId){
        $user=User::find($userId);
        $image_file=Image::make($user->profile_picture);
        $response=Response::make($image_file->encode('jpeg'));
        $response->header('Content-Type','image/jpeg');
        return $response;
    }
}
