<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\TinTucService;
use App\Models\TinTuc;

class TinTucApi extends Controller
{
    public function getAll(Request $request){
        $filter = $request->input("filter");
        $start = $request->input("start");
        $limit = $request->input("limit");
        return TinTucService::getAll($filter, $start, $limit);
    }
    public function getAllInClient(Request $request){
        return TinTucService::getAllInClient();
    }
    public function getCount(Request $request){
        $filter = $request->input("filter");
        $start = $request->input("start");
        $limit = $request->input("limit");
        return TinTucService::getCount($filter, $start, $limit);
    }
    public function create(Request $request){
        return TinTucService::create($request);
    }
    public function update(Request $request){
        return TinTucService::update($request);
    }
    public function getById(Request $request){
        $id = $request->input("id");
        return TinTucService::getById($id);
    }
    public function getTinTucByLoaiTinTuc(Request $request){
        return TinTucService::getTinTucByLoaiTinTuc($request);
    }
    public function getListTinTucByLoaiTinTucInClient(Request $request){
        return TinTucService::getListTinTucByLoaiTinTucInClient($request);
    }
    //LOAI TIN TUC
    public function getAllActive(){
        return TinTucService::getAllActive();
    }
    public function getAllLoaiTinTuc(Request $request){
        $filter = $request->input("filter");
        $start = $request->input("start");
        $limit = $request->input("limit");
        return TinTucService::getAllLoaiTinTuc($filter, $start, $limit);
    }
    public function getCountLoaiTinTuc(Request $request){
        $filter = $request->input("filter");
        $start = $request->input("start");
        $limit = $request->input("limit");
        return TinTucService::countLoaiTinTuc($filter, $start, $limit);
    }
    public function getLoaiTinTucById(Request $request){
        $id = $request->input("id");
        return TinTucService::getByIdLoaiTintuc($id);
    }
    public function createLoaiTinTuc(Request $request){
        return TinTucService::createLoaiTinTuc($request);
    }
    public function updateLoaitinTuc(Request $request){
        return TinTucService::updateLoaiTinTuc($request);
    }
    public function duyetBai(Request $request){
        return TinTucService::duyetBai($request);
    }
    public function getByIdClient(Request $request){
        $guid = $request->input("id");
        $loaiTinTucId = $request->input("loaiTinTucId");
        return TinTucService::getByIdClient($guid, $loaiTinTucId);
    }
    public function getByIdLoaiTinTucClient(Request $request){
        $id = $request->input("id");
        return TinTucService::getByIdLoaiTinTucClient($id);
    }
}
