<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\TheLoaiGameService;



class TheLoaiGameApi extends Controller
{
    public static function getAll(Request $request){
        $filter = $request->input("filter");
        $start = $request->input("start");
        $limit = $request->input("limit");
        return TheLoaiGameService::getAll($filter, $start, $limit);
    }
    public static function getAllActive(){
        return TheLoaiGameService::getAllActive();
    }
    public static function create(Request $request){
        return TheLoaiGameService::create($request);
    }
    public static function getById(Request $request){
        $id = $request->input("id");
        return TheLoaiGameService::getById($id);
    }
    public static function update(Request $request){
        return TheLoaiGameService::update($request);
    }
}
