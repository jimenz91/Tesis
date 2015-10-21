<?php

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//Get all users
$result = mysql_query("SELECT * FROM usuario ORDER BY id DESC") or die(mysql_error());

if (mysql_num_rows($result) > 0) {
	$count = 0;
	while($row=mysql_fetch_array($result)){
		$password = $row['password'];
		$md5_pass = md5($password);
		$uid = $row['id'];
		mysql_query("UPDATE usuario SET password='$md5_pass' WHERE id = '$uid'") or die(mysql_error());
		$count = $count + 1;
	}

	echo "Success. Rows Affected: ".$count;

}else {
	echo "Failure";
}




?>