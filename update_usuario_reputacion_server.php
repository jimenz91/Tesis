<?php

// include db connect class
require_once __DIR__ . '/db_connect.php';
// connecting to db
$db = new DB_CONNECT();

$result = mysql_query("SELECT id,reputacion FROM usuario") or die(mysql_error());

if (mysql_num_rows($result) > 0){
	while($row=mysql_fetch_array($result)){
		$id = $row['id'];
		$reputacion = $row['reputacion'];
		$result2 = mysql_query("SELECT reputacion FROM pregunta WHERE usuario_id = '$id'") or die(mysql_error());
		if(mysql_num_rows($result2) > 0 ){
			while($row2=mysql_fetch_array($result2)){
				$reputacion = $reputacion+$row2['reputacion'];
			}
			mysql_query("UPDATE usuario SET reputacion = '$reputacion' WHERE id = '$id'") or die(mysql_error());
		}
	}
}


?>