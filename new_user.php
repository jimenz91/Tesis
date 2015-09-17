<?php

error_reporting(0);

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['nombre']) && isset($_POST['apellido']) && isset($_POST['correo']) && isset($_POST['user']) && isset($_POST['password']) && isset($_POST['carrera_id'])) {
    
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
	$user = $_POST['user'];
	$password = $_POST['password'];
	$carrera_id = $_POST['carrera_id'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql inserting a new row
    $result = mysql_query("INSERT INTO usuario(nombre, apellido, correo, user, password, carrera_id) VALUES('$nombre', '$apellido', '$correo', '$user', '$password', '$carrera_id')");

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Usuario creado.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Error en la creación del usuario.";
        
        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Campo requerido vacio.";

    // echoing JSON response
    echo json_encode($response);
}
?>