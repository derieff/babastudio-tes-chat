<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use Carbon\Carbon;
use Input, Validator;
use DB, Hash, Mail;
use Session;

use Alert;
use Redirect;

class UserController extends Controller
{
    public function index(){
    	$data = User::get();
    	return $data;
    }
}
