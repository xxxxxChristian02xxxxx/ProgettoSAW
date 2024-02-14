<?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the raw POST data
$postData = file_get_contents("php://input");

// Decode the JSON data
$data = json_decode($postData, true); // prendo i dati che mi erano stati mandati dal login frontend tramite jason con apifetch

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $data['email'];
    $email = trim($email);
    $password = $data['pass'];
    $password = trim($password);
    if ($data['ReMe']) {
        $remember = true;
    } else {
        $remember = false;
    }

    //Connessione al db
    include('function_files/connection.php');
    $con = connect();

    //Preparazione della query
    //todo: transform to prepared stmt
    $query = "SELECT * FROM USERS WHERE EMAIL= ? ";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $res = $stmt->get_result();

    header('Content-Type: application/json');
    if($res->num_rows !== 1){
        $response = array("success" => false);
    }
    else{
        $row = $res->fetch_assoc();
        $storedPassword = $row["PASSWORD"];

        if (password_verify($password, $storedPassword)) {
            require('function_files/session.php');
            setSession($row['ID']);

            if($remember) {
                require('function_files/RememberMe.php');
                setRememberMe($remember);
            }

            http_response_code(200);
            $response = array("success" => true);
        }else{
            $response = array("success" => false);
        }
    }
    $con->close();
    echo json_encode($response);
}
