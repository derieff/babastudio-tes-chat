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
use Response;

class MessageController extends Controller
{
    public function index(Request $request){
    	$select = DB::table('messages')
    		->select('messages.*', 'users.name')
    		->join('users', 'users.id', 'messages.user_id')
    		->get();
    	return $select;
    }

    public function store(Request $request){
    	$data = [
    		'user_id' => $request->user_id,
    		'text' => $request->text,
    	];

    	$insert = Messages::insert($data);

    	// return Response::json(['code' => '200', 'status' => true,
     //        'message' => 'Berhasil kirim pesan'
     //    ], 200);
        Alert::success("Berhasil Kirim Pesan");
    	return Redirect::to('');
    }
}
