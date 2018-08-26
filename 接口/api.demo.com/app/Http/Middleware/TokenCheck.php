<?php

namespace App\Http\Middleware;

use App\Exceptions\Apiexception;
use Closure;
use App\User;

class TokenCheck
{
//    问题：openid放在什么地方能不用查数据库
    public function handle($request, Closure $next)
    {
        $username = $request->header('username','');
        $password = $request->header('password','');
        $time     = $request->header('timestamp',0);
        $key      = $request->header('openid','admin');
        $rand     = $request->header('rand','');
        $usign    = $request->header('usign','');

        $sign    =sha1(md5(md5($key.$time).$rand)) ;
//        if($usign != $sign)
//        {
//            throw  new Apiexception('用户名或密码错误0',1001);
//            //return response()->json(['sign'=>$sign,'usign'=>$usign,'rand'=>$rand,'openid'=>$key,'time'=>$time],200);
//        }
        $data = User::where('username',"$username")->first();
        //怎样实现超时自动刷新功能？
        if(!empty($data))
        {
//            if(time() - $data->time_out > 0)
//            {
//                throw  new Apiexception('账户过期，请重新登陆',1004);
//            }

            if($data->password != $password)
            {
                throw  new Apiexception('用户名或密码错误2',1003);
                return response()->json(['username'=>$username,'data'=>$data,],200);
            }
        }else{
            //throw  new Apiexception('用户名或密码错误1',1002);
            return response()->json(['username'=>$username,'data'=>$data,],200);
        }
        return $next($request);
    }
}
