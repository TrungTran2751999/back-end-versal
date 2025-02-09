<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\TeamService;


class TeamApi extends Controller
{
    public function getAllActive(){
        return TeamService::getAllActive();
    }
    public function getAll(Request $request){
        $filter = $request->input("filter");
        $start = $request->input("start");
        $limit = $request->input("limit");
        return TeamService::getAll($filter, $start, $limit);
    }
    public function getById(Request $request){
        $id = $request->input("id");
        $guid = $request->input("guid");
        return TeamService::getById($id, $guid);
    }
    public function create(Request $request){
        return TeamService::create($request);
    }
    public function update(Request $request){
        return TeamService::update($request);
    }
    public function getMemberOfTeam(Request $request){
        $filter = $request->input("filter");
        $start = $request->input("start");
        $limit = $request->input("limit");
        return TeamService::getMemberOfTeam($filter, $start, $limit);
    }
    public function addMemberTeam(Request $request){
        return TeamService::addMember($request);
    }
    public function xoaMemberTeam(Request $request){
        $userId = $request["userId"];
        $teamId = $request["teamId"];
        return TeamService::xoaMemberOfTeam($userId, $teamId);
    }
}
