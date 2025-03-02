<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(){
        return view("client/index");
    }
    //Blog
    public function blog(){
        return view("client/blog/index");
    }
    public function blogDetail(){
        return view("client/blog/detail");
    }
}
