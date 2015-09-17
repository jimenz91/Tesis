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
$result = mysql_query("SELECT *FROM pregunta ORDER BY id DESC") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["questions"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp question array
        $question = array();
        $question["qid"] = $row["id"];
        $question["enunciado"] = utf8_encode($row["enunciado"]);
        $question["foto"] = $row["foto"];
        $question["tema_id"] = utf8_encode($row["tema_id"]);
        $question["username"] = utf8_encode($row["username"]);
        $question["reputacion"] = utf8_encode($row["reputacion"]);
		//echo $question["name"] . "\n";
	//	echo json_encode($question) . "\n";
	//	echo json_last_error();
        // push single product into final response array
        array_push($response["questions"], $question);
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

    // echo no questions JSON
    echo json_encode($response);
	//echo json_last_error();	
}
?>
