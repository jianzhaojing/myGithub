<?php
$uname = 'admin';
$pass  = 'admin';
$rand  = mt_rand(10000,99999);
$openid = 'admin';//用不用传openid到服务器,注册时自动入库自动调取
$timestamp = time();
$usign = makeToken($openid,$timestamp,$rand);
function makeToken($openid,$timestamp,$rand)
{
    $sign    = sha1(md5(md5($openid.$timestamp).$rand));
    return $sign;
}
//设置header头信息
$header=[
    'username:'.$uname,
    'password:'.$pass,
    'timestamp:'.$timestamp,
    'openid:'.$openid,
    'rand:'.$rand,
    'usign:'.$usign,
];
//使用curl发送请求
        //初始化
       $ch = curl_init();
        //设置路由
        curl_setopt($ch,CURLOPT_URL,'http://api.demo.com/api/v1/articles');
        //不返回header头
        curl_setopt($ch,CURLOPT_HEADER,0);
        //不返回信息
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //设置header头
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
        //发送post请求
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,[
            'title'=>'curl2',
            'author'=>'jerry',
            'desc'=>'hhhhhhhhhh'
        ]);
        //执行命令
        $data = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        var_dump($data);