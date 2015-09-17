<?php
error_reporting(0);
/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();


// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// get all products from products table
$result = mysql_query("SELECT *FROM comentario_respuesta") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["comments"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp comment array
        $comment = array();
        $comment["cid"] = $row["id"];
        $comment["comentario"] = utf8_encode($row["comentario"]);
        $comment["respuesta_id"] = utf8_encode($row["respuesta_id"]);
		//echo $comment["name"] . "\n";
	//	echo json_encode($comment) . "\n";
	//	echo json_last_error();
        // push single product into final response array
        array_push($response["comments"], $comment);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
	//echo json_last_error_msg();
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No question found";

    // echo no comments JSON
    echo json_encode($response);
	//echo json_last_error();	
}
?>
