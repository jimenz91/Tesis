<?php
//Disable Error Reporting
error_reporting(0);


// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();


if(isset($_POST["reputation"])&&isset($_POST["aid"])&&isset($_POST["uid"])){
	$reputation = $_POST["reputation"];
    $username = $_POST["uid"];
	$aid = $_POST["aid"];
	
	if($reputation=="up"){
		$result = mysql_query("UPDATE respuesta SET reputacion = reputacion+1 WHERE id = '$aid'") or die(mysql_error());
        $message = 'Reputación +1';
	}else{
		$result = mysql_query("UPDATE respuesta SET reputacion = reputacion-1 WHERE id = '$aid'")or die(mysql_error());
        $message = 'Reputación -1';
	}
		

    // check if row inserted or not
    if (mysql_affected_rows()>0) {
        //successfully inserted into database
        if($reputation=="up"){
        $result2 = mysql_query("UPDATE usuario SET reputacion = reputacion+1 WHERE user = '$username'")or die(mysql_error());
    }else{
        $result2 = mysql_query("UPDATE usuario SET reputacion = reputacion-1 WHERE user = '$username'")or die(mysql_error());
    }
    if (mysql_affected_rows()>0) {
        $response["success"] = 1;
        $response["message"] = utf8_encode($message);
                // echoing JSON response
        echo json_encode($response);
    }else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Error en la actualizacion.";
        
        // echoing JSON response
        echo json_encode($response);
    }


    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Error en la actualizacion.";
        
        // echoing JSON response
        echo json_encode($response);
    }
	
}else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Error en la actualizacion.";
        
        // echoing JSON response
        echo json_encode($response);
    }

















?>