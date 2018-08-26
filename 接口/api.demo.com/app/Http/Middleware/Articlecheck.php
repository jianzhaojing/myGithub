<?php

namespace App\Http\Middleware;

use App\Exceptions\Apiexception;
use Closure;

class Articlecheck
{

    public function handle($request, Closure $next)
    {
        $username = $request->header('username','jerry');
        $password = $request->header('admin','admin');
        if($username !='jerry')
        {
            //return response()->json(['code'=>1000,'message'=>'用户名不正确'],400);
            throw new Apiexception('用户名不正确','1000');
        }
        return $next($request);
    }
}
