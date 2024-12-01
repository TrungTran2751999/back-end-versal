<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Service\UserService;
use DB;


class UserApi extends Controller
{
    public function getAll(){
        return UserService::getAll();
    }
    public function getById(Request $request){
        $id = $request->input("id");
        return UserService::getById($id);
    }
    
    public function login(Request $request){
        return UserService::login($request);
    } 
    public function logout(){
        return UserService::logout();
    }
    public function create(Request $request){
        return UserService::create($request);
    }
    public function update(Request $request){
        return UserService::update($request);
    }
    
    public function changePass(Request $request){
        return UserService::changePass($request);
    }
    
}
