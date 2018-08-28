<?php 
function link_pdo()
{
	 $dns = 'mysql:dbname=edu67;host=127.0.0.1';
	 $user = 'root';
	 $password = 'root';
	try{
		 $pdo = new PDO($dns,$user,$password);
		}catch(PDOException $e){
			echo $e->getmessage();
		}
	return $pdo;
}
$sql = 'select * from edu_auths';
$arrs = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);


