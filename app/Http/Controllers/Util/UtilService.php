<?php

namespace App\Http\Controllers\Util;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Naopon\LaravelGoogleDrive\Facades\GoogleDrive;
use Storage;
use Cloudder;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class UtilService extends Controller
{
    public static function upload($file){
        $path = Storage::disk('google')->put("/",$file, ['visibility' => 'public']);
        $result = Storage::disk('google')->getMetadata($path);
        $image = new Image();
        $idMax = Image::max("id")+1;
        $image->id =  $idMax;
        $image->fileName = $result["name"];
        $image->path = $result["path"];
        $image->save();
        return $idMax;
    }
    public static function updateAvartar($fileName, $fileId){
        $newFileId = Storage::disk('google')->putFileAs("/", $fileName, $fileId, ['visibility' => 'public']);
        return response("OK",200);
    }
    public static function getAll(){
        $path = Storage::disk('google')->listContents("/", false);
        return $path;
    }
    public static function sendNotificate($title, $content, $arrDeviceToken){
        for($i=0; $i<count($arrDeviceToken); $i++){
            $response = Http::withHeaders([
                'Content-Type'=> 'application/json; charset=UTF-8',
                'Authorization'=>env("CLOUND_FIREBASE")
            ])->post('https://fcm.googleapis.com/fcm/send', [
                'to'=>$arrDeviceToken[$i]["deviceToken"],
                'priority'=>'high',
                'notification'=>[
                    'title'=> $title,
                    'body'=>$content
                ],
                'data'=>[
                    'id'=>"1",
                    "name"=>"fuckkkk"
                ]
            ]);
            // if ($response->successful()) {
            //     $data = $response->json();
            //     return $data;
            // } else {
            //     // Handle the API error
            //     $statusCode = $response->status();
            //     $errorMessage = $response->body();
            //     return $errorMessage;
            //     // ...
            // }
        }
    }
    public static function IsNullOrEmpty($str){
        if($str === null || $str ===""){
            return true;
        }else{
            return false;
        }
    }
    public static function SqlHasCondition($listCondition){
        $condition = "";
        for($i=0; $i < count($listCondition); $i++){
            if(!UtilService::IsNullOrEmpty($listCondition[$i])){
                $paramCondition = $listCondition[$i];
                if($condition == ""){
                    $condition = $condition." WHERE $paramCondition";
                }else{
                    $condition = $condition." AND $paramCondition";
                }
            }
        }
        return $condition;
    }
}
