<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Messages;
use App\Files;

use Carbon\Carbon;
use Input, Validator;
use DB, Hash, Mail;
use Session;

use Alert;
use Redirect;

class ProcessController extends Controller
{
    public function store_message(Request $request){
    	$validator = Validator::make($request->all(), [
    		'' => 'required|max:50',
            'username' => 'required|max:50',
            'password' => 'required',
        ]);
        $user_id = $request->user_id;
    }

    public function register_process(Request $request){
    	// return "asd";
    	$name = $request->name;
    	$email = $request->email;
    	$password = $request->password;
    	$conf_password = $request->conf_password;

    	$select = User::select('*')
    		->where('email', $email)
    		->first();
    	if( !empty($select) ){
    		Alert::error("Email sudah dipakai, gunakan email lain");
            return Redirect::to('form-register');
    	}

    	if($password != $conf_password){
    		Alert::error("Password tidak sama");
            return Redirect::to('form-register');
    	}

    	$data = [
    		'name' => $name,
    		'email' => $email,
    		'password' => md5($password),
    	];

    	$insert = User::insert($data);

    	if($insert){
    		Alert::success("Berhasil daftar. Silahkan login");
            return Redirect::to('form-login');
    	}else{
    		Alert::error("Terjadi kesalahan. Periksa kembali");
            return Redirect::to('form-register');
    	}
    }

    public function login_process(Request $request){
    	$email = $request->email;
    	$password = md5($request->password);

    	$select = User::select('*')
    		->where('email', $email)
    		->where('password', $password)
    		->first();

    	if( empty($select) ){
    		Alert::error("Username atau Password salah");
            return Redirect::to('form-login');
    	}else{
    		Session::put('status_login', '1');
    		Session::put('data_user', $select);
    		Session::put('user_id', $select['id']);
    		Alert::success("Berhasil Login");
    		return Redirect::to('');
    	}
    }

    public function logout_process(Request $request){
    	Session::flush();
    	Alert::success('Anda berhasil Log Out');
        return Redirect::to('');
    }
}
