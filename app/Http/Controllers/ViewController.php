<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Validator;
use Redirect;
use Carbon\Carbon;
use Alert;

class ViewController extends Controller
{
    public function welcome(Request $request){
    	if( empty(Session::get('status_login')) ){
    		return view('login');
    	}else{
    		return view('chat');	
    	}
    }

    public function login(Request $request){
    	return view('login');
    }

    public function register(Request $request){
    	return view('register');
    }
}
