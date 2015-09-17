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
$result = mysql_query("SELECT *FROM usuario") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all results
    // products node
    $response["users"] = array();
    
    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $user = array();
        $user["uid"] = $row["id"];
        $user["nombre"] = utf8_encode($row["nombre"]);
        $user["apellido"] = utf8_encode($row["apellido"]);
        $user["correo"] = utf8_encode($row["correo"]);
        $user["nickname"] = utf8_encode($row["user"]);
        $user["password"] = utf8_encode($row["password"]);
		$user["carrera_id"] = utf8_encode($row["carrera_id"]);
		//echo $user["name"] . "\n";
	//	echo json_encode($user) . "\n";
	//	echo json_last_error();
        // push single product into final response array
        array_push($response["users"], $user);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
	//echo json_last_error_msg();
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No user found";

    // echo no users JSON
    echo json_encode($response);
	//echo json_last_error();	
}
?>
