<?php
error_reporting(0);

/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */

// array for JSON response

$response = array();
$host = "http://192.168.1.113/michigan_server";
$upload_base_folder = __DIR__ . "\\uploads\\";
$web_upload_folder = "/uploads";

// var_dump($_POST);
// var_dump($_FILES);
// var_dump($_REQUEST);

// check for required fields
if (isset($_POST['enunciado']) && isset($_FILES['uploaded_file']) && isset($_POST['tema_id']) && isset($_POST['usuario_id']) && isset($_POST['username'])) {
    

   
    $enunciado = utf8_decode($_POST['enunciado']);
    $tema_id = $_POST['tema_id'];
    $usuario_id = $_POST['usuario_id'];
    $username = $_POST['username'];
    $upload_file_path = $upload_base_folder . $username . "\\" . basename($_FILES["uploaded_file"]["name"]);
    
    if(!file_exists($upload_base_folder . $username)){
        mkdir($upload_base_folder . $username);
    }

    //move
    if(move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], $upload_file_path)){
         $foto = $host . $web_upload_folder . "/" . $username . "/" . basename($_FILES["uploaded_file"]["name"]);
        //echo "Upload successful";
    }else{
        $foto = "No photo";
        //echo "Failed to move to: ". $upload_file_path;
    }
    


    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql inserting a new row
    $result = mysql_query("INSERT INTO pregunta(enunciado, foto, tema_id, usuario_id, username) VALUES('$enunciado', '$foto', '$tema_id', '$usuario_id', '$username')");

    // check if row inserted or not
    if ($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Pregunta creada.";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "Error en la creación de la pregunta.";
        
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