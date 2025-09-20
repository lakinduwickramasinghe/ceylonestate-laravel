<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function admin_index(){
        return view('feedback.admin_index');
    }
    public function admin_view($id){
        return view('feedback.admin_view', ['id' => $id]);
    }
    public function index($id) {
        return view('feedback.index', ['id' => $id]);
    }

    public function show($id){
        return view('feedback.show', ['id' => $id]);
        
    }
        public function edit($id){
            return view('feedback.edit', ['id' => $id]);
        }
}
