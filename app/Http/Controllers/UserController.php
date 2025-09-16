<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('user.index');
    }
    public function show($id){
        return view('user.show',compact('id'));
    }
}
