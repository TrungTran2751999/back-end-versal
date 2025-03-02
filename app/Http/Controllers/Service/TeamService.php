<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Http\Controllers\Util\UtilService;
use App\Models\Team;
use App\Models\TeamMember;
use DB;

class TeamService
{
    public static function getAllActive(){
        return Team::where("isDeleted", false)->get();
    }
    public static function getAll($filter, $start, $limit){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " (name LIKE '%$keyWord%')" 
        : "";

        $status = $filter["status"];
        $sqlStatus = $status >= 0 ? " isBan = $status" : "";


        $sqlPhanTrang = $limit > 0 ? " LIMIT $limit OFFSET $start" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlStatus]);
        
        $sql = "SELECT * FROM team $listCondition $sqlPhanTrang";

        $sqlCount = "SELECT COUNT(id) as count FROM team $listCondition";

        $result = [
            "listData"=>DB::select($sql),
            "count"=>DB::select($sqlCount)
        ];

        return response($result, 200);
    }
    public static function getById($id, $guid){
        return Team::where("guid", $guid)->where("id", $id)->first();
    }
    public static function create($request){
        DB::beginTransaction();
        try{

            $name = $request->input("name");
            $checkName = Team::where("name", $name)->first();
            if($checkName!=null) return response("Tên đã tồn tại", 400);
            
            $team = new Team();
            $team->name = $request->input("name");
            $team->guid = Str::uuid()->toString();
            $team->description = $request->input("description");
            $team->image = $request->input("image");
            $team->userId = $request->input("userId");
            $team->theLoaiGameId = $request->input("theLoaiGameId");
            $team->updatedBy = $request->input("updatedBy");
            $team->createdBy = $request->input("updatedBy");
            $team->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
            $team->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
            $team->isBan = 0;
            $team->id = Team::max("id") + 1;
            $team->positionLeader = $request->input("positionLeader");

            $teamMember = [];
            $teamMember["teamId"] = $team->id;
            $teamMember["userId"] = $team->userId;
            $teamMember["position"] = $request->input("positionLeader");
            $teamMember["updatedBy"] = $request->input("updatedBy");

            $team->save();

            TeamService::addMember($teamMember, $request);
            DB::commit();
        }catch(Exeption $e){
            DB::rollBack();
        }
    }
    public static function update($request){
        $name = $request->input("name");
        $id = $request->input("id");
        $guid = $request->input("guid");
        $checkName = Team::where("id","<>", $id)->where("name", $name)->first();
        if($checkName != null) return response("Tên đã tồn tại", 400);

        $team = Team::where("id", $id)->where("guid", $guid)->first();
        if($team != null){
            $team->name = $name;
            $team->description = $request->input("description");
            $team->image = $request->input("image");
            $team->theLoaiGameId = $request->input("theLoaiGameId");
            $team->isBan = $request->input("status");
            $team->save();
            return response("OK",200);
        }
        return response("FAIL",500);
    }
    public static function addMember($teamMemberRes){
        $teamId = $teamMemberRes["teamId"];
        $userId = $teamMemberRes["userId"];
        
        $checkMember = TeamMember::where("userId", $userId)->where("teamId", $teamId)->first();
        if($checkMember!=null) return response("Member đã tồn tại", 400);
        $teamMember = new TeamMember();
        $teamMember->position = $teamMemberRes["position"];
        $teamMember->teamId = $teamId;
        $teamMember->userId = $userId;
        $teamMember->createdBy = $teamMemberRes["updatedBy"];
        $teamMember->updatedBy = $teamMemberRes["updatedBy"];
        $teamMember->createdAt = Carbon::now('Asia/Ho_Chi_Minh');
        $teamMember->updatedAt = Carbon::now('Asia/Ho_Chi_Minh');
        $teamMember->id = TeamMember::max("id") + 1;
        $teamMember->isDeleted = 0;
        $teamMember->save();
    }
    public static function getMemberOfTeam($filter, $start, $limit){
        $keyWord = $filter["keyWord"];
        $sqlKeyWord = !UtilService::IsNullOrEmpty($keyWord) ? 
        " (u.name LIKE '%$keyWord%')" 
        : "";

        $id = $filter["id"];

        $status = $filter["status"];
        $sqlStatus = $status >= 0 ? " tm.isDeleted = $status" : "";

        $sqlPhanTrang = $limit > 0 ? " LIMIT $limit OFFSET $start" : "";

        $listCondition = UtilService::SqlHasCondition([$sqlKeyWord, $sqlStatus]);

        $members = DB::select("SELECT tm.position, u.id, u.name , tm.isDeleted, tm.position
                                FROM user as u JOIN team_member as tm
                                ON u.id = tm.userId $listCondition AND tm.teamId = $id $sqlPhanTrang");
        $memberTotal = DB::select("SELECT COUNT(u.id) as count
                                FROM user as u JOIN team_member as tm
                                ON u.id = tm.userId $listCondition AND tm.teamId = $id");
        $result = [];
        $result["members"] = $members;
        $result["total"] = $memberTotal;
        return $result;
    }
    public static function xoaMemberOfTeam($userId, $teamId){
        $memberXoa = TeamMember::where("userId", $userId)->where("teamId", $teamId)->first();
        if($memberXoa==null) return response("member không tồn tại", 400);
        $memberXoa->isDeleted = 1;
        $memberXoa->save();
    }
}
