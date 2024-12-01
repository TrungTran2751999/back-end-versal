<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Role;
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
            $userRole = Role::where("id", $token->roleId)->first();
            $arrRole = explode(";",$role);
            for($i=0; $i<count($arrRole); $i++){
                if($arrRole[$i] == $userRole->name){
                    return $next($request);
                }
            }
            return response("Unauthorized", 401);
        }catch(Exeption $e){
            return response("Unauthorized",401);
        }
    }
}
