<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Auth;

class ContactController extends Controller
{
    public function delete($userId){
        Contact::where([
            ['user_a',Auth::user()->id],
            ['user_b',$userId]
        ])->orWhere([
            ['user_b',Auth::user()->id],
            ['user_a',$userId]
        ])->delete();
        return redirect()->back()->with(
            'success',
            'Se ha eliminado.'
        );
    }
}
