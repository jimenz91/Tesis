<?php
error_reporting(0);
/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();



if((isset($_GET["keywords"]))&&(isset($_GET["materia_id"]))){
$search = "%" . str_replace(' ', '%', $_GET["keywords"]) . "%";
$materia_id = $_GET["materia_id"];
// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// get all products from products table
$result = mysql_query("SELECT * from pregunta INNER JOIN tema ON pregunta.tema_id=tema.id AND tema.materia_id = '$materia_id' AND pregunta.enunciado LIKE '$search' ") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["questions"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp question array
        $qid=$row["id"];
        $answer_count_query = mysql_query("SELECT COUNT(pregunta_id) FROM respuesta WHERE pregunta_id = '$qid'") or die(mysql_error());
        $row2 = mysql_fetch_array($answer_count_query);
        $question = array();
        $question["qid"] = $row["id"];
        $question["answer_count"] = $row2["COUNT(pregunta_id)"];
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

}
?>