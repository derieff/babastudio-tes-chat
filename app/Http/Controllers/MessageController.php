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
    		->select('messages.*', 'users.name', 'files.title', 'files.file')
    		->join('users', 'users.id', 'messages.user_id')
    		->leftJoin('files', 'files.id', 'messages.file_id')
    		->orderBy('messages.id', 'asc')
    		->get();
    	return $select;
    }

    public function store(Request $request){
    	return $request->all();
    	$message = new Messages;
    	$message->user_id = $request->user_id;
    	$message->text = $request->text;
    	$message->created_at = Carbon::now();
    	$message->updated_at = Carbon::now();
    	$message->save();

    	if( !empty($request->file) ){
    		$message_id = $message->id;

    		$file = $request->file('file');
    		$file_extension = $file->getClientOriginalExtension();
	        $file_name = $file->getClientOriginalName();
	        $file_name = str_replace('.'.$file_extension, '', $file_name);
	        $new_file_name = $this->seoName($file_name).'_'.uniqid().'.'.$file_extension;
	        $file->move(base_path('public\files\stored'), $new_file_name);

	        $file = new Files;
	        $file->message_id = $message_id;
	        $file->title = $request->title_file;
	        $file->file = $new_file_name;
	        $file->created_at = Carbon::now();
	        $file->updated_at = Carbon::now();
	        $file->save();

	        $file_id = $file->id;

	        $data = [
	        	'file_id' => $file_id,
	        ];

	        $update_message = Messages::where('id', $message_id)
	        	->update($data);

    	}

        Alert::success("Berhasil Kirim Pesan");
    	return Redirect::to('');
    }

    public function seoName($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }
}
