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

if (isset($_GET["usuario_id"])){
  $user = $_GET['usuario_id'];

    // get all products from products table
    $result = mysql_query("SELECT * FROM (
    SELECT * FROM pregunta WHERE pregunta.id IN (
        SELECT pregunta_id FROM respuesta WHERE usuario_id = '$user')
) AS x INNER JOIN ( SELECT pregunta_id,COUNT(*) AS count FROM respuesta GROUP BY pregunta_id) y ON x.id = y.pregunta_id ORDER BY x.id DESC") or die(mysql_error());

    // check for empty result
    if (mysql_num_rows($result) > 0) {
        // looping through all results
        // products node
        $response["questions"] = array();
    
        while ($row = mysql_fetch_array($result)) {
            // temp question array
            $question = array();
            $question["qid"] = $row["id"];
            $question["answer_count"] = $row["count"];
            $question["enunciado"] = utf8_encode($row["enunciado"]);
            $question["foto"] = $row["foto"];
            $question["tema_id"] = utf8_encode($row["tema_id"]);
            $question["username"] = utf8_encode($row["username"]);
            $question["reputacion"] = utf8_encode($row["reputacion"]);
    		
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
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>
