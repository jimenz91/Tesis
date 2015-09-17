<?php
error_reporting(0);

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['comentario']) && isset($_POST['foto']) && isset($_POST['respuesta_id']) && isset($_POST['usuario_id']) && isset($_POST['username'])) {
    
    $comentario = $_POST['comentario'];
    $respuesta_id = $_POST['respuesta_id'];
    $usuario_id = $_POST['usuario_id'];
    $username = $_POST['username'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql inserting a new row
    $result = mysql_query("INSERT INTO comentario_respuesta(comentario, respuesta_id, usuario_id, username) VALUES('$comentario', '$respuesta_id', '$usuario_id', '$username')");

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Comentario creado.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Error en la creación del comentario.";
        
        // echoing JSON response
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