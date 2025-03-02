<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Role;
use App\Models\User;
class JwtMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
        try{
            $token = JWTAuth::parseToken()->authenticate();
            //$userRole = User::where("id", $token->id)->first();
            $arrRole = explode(";", "0;1");
            for($i=0; $i<count($arrRole); $i++){
                if($arrRole[$i] == $token->id){
                    return $next($request);
                }
            }
            return response("Success", 200);
        }catch(Exeption $e){
            return response("Unauthorized",401);
        }
    }
}
