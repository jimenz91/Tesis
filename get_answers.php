<?php
error_reporting(0);
/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();
if(isset($_GET["pregunta_id"])){

$pregunta_id = $_GET["pregunta_id"];

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// get all products from products table
$result = mysql_query("SELECT *FROM respuesta WHERE pregunta_id = '$pregunta_id' ORDER BY id DESC") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["answers"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp answer array
        $answer = array();
        $answer["aid"] = $row["id"];
        $answer["respuesta"] = utf8_encode($row["respuesta"]);
        $answer["foto"] = utf8_encode($row["foto"]);
        $answer["pregunta_id"] = utf8_encode($row["pregunta_id"]);
        $answer["username"] = utf8_encode($row["username"]);
        $answer["reputacion"] = $row["reputacion"];
		//echo $answer["name"] . "\n";
	//	echo json_encode($answer) . "\n";
	//	echo json_last_error();
        // push single product into final response array
        array_push($response["answers"], $answer);
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

    // echo no answers JSON
    echo json_encode($response);
	//echo json_last_error();	
}
}else{
    //Required field missing
    $response["success"] = 0;
    $response["message"] = "Required field missing!";
    echo json_encode($response);
}
?>
