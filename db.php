<?php
header("Cache-Control: no-cache, must-revalidate");
$db = new PDO($connectionDetails["db"], $connectionDetails["username"], $connectionDetails["password"],array('charset'=>'utf8'));
$db->exec("set names utf8");
$lastId = false;
function query_result($query){
	global $db;
	$q = $db->prepare($query);
	$q->execute()or logerror($query,$db->errorInfo());
	if(strpos($query,'insert into')!== false){
		return $db->lastInsertId();
	}else{
    	$rows = $q->fetchAll();
		return $rows;
	}
}

function logerror($query,$error){
    $err = serialize($error);
    file_put_contents("error.log",$query.PHP_EOL.$err);
    exit();
}

?>