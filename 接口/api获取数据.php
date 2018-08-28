<?php

$ch = curl_init();
$mysqli = new mysqli('localhost','root','root','web67');
$page = 1;
for($i=0;$i++;$i<3)
{
	$url = "http://pub.cloudmob.mobi/publisherapi/offers/?uid=92&key=d4bab08884781dbf2bede528e27d243d&limit=1000&page=$page";
	$data = httpGet($url);
	$arrs = json_decode($data,true);
	foreach($arrs as $v)
	{
		link_mysqli($mysqli,$v[0],$v[1]);
		if(!$ret)
		{
			echo '执行失败:'.$ret->error;
		}
	}
	$page+=1;
	$mysqli->close();
}
$curl_close($ch);

function httpGet($url)
{
	//$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	$data = curl_exec($ch);
	//curl_close($ch);
	return $data;
}

function link_mysqli($Mysqli,$username,$password)
{
	//$mysqli = new mysqli('localhost','root','root','web67');
	$mysqli->set_charset('gb2312');
	$sql = 'insert into article (username,password) values (?,?)';
	$ret = $mysqli->prepare($sql);
	$mysqli->bind_param("ss",$username,$password);
	$mysqli->execute();
	return $ret;
}