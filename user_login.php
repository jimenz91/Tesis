<?php
error_reporting(0);
/*
 * Following code will get single product details
 * A product is identified by product id (pid)
 */

// array for JSON response
$response = array();


// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// check for post data
if (isset($_POST["usuario"])&&isset($_POST["contrasena"])) {
  $user = $_POST['usuario'];
  $password = md5($_POST['contrasena']);

    // get a product from products table
    $result = mysql_query("SELECT *FROM usuario WHERE user = '$user' AND password = '$password'");

    if (!empty($result)) {
        // check for empty result
        if (mysql_num_rows($result) > 0) {

            $result = mysql_fetch_array($result);

            $usuario = array();
            $usuario["id"] = $result["id"];
            $usuario["user"] = $result["user"];
            $usuario["nombre"] = utf8_encode($result["nombre"]);
            $usuario["apellido"] = utf8_encode($result["apellido"]);
            $usuario["correo"] = $result["correo"];
            $usuario["foto"] = $result["foto"];
            $usuario["reputacion"] = $result["reputacion"];
            $usuario["carrera_id"] = $result["carrera_id"];
            
			// success
            $response["success"] = 1;

            // user node
            $response["usuario"] = array();

            array_push($response["usuario"], $usuario);

            // echoing JSON response
            echo json_encode($response);
        } else {
            // no product found
            $response["success"] = 0;
            $response["message"] = "Usuario/Contrasena invalidos.";

            // echo no users JSON
            echo json_encode($response);
        }
    } else {
        // no product found
        $response["success"] = 0;
        $response["message"] = "Usuario/Contrasena invalidos.";

        // echo no users JSON
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>