<?php
session_start();
require ('function_files/inputCheck.php');

$postData = file_get_contents("php://input");

$data = json_decode($postData, true);

if ($data && $_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $data['email'];
    $email = trim($email);
    $password = $data['pass'];
    $password = trim($password);
    if(!inputMailcheck($email)){
        echo json_encode('no valid email');
    }

    if ($data['ReMe']) {
        $remember = true;
    } else {
        $remember = false;
    }

    $response = login($email, $password, $remember);

    echo json_encode($response);
}

function login($email, $password, $remember){
    //Connessione al db
    include('function_files/connection.php');
    $con = connect();

    //Preparazione della query con prepared statement
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
        if($row['BANNED']){
            $response = array("success" => false, "banned" => true);
        }
        else{
            $storedPassword = $row["PASSWORD"];

            if (password_verify($password, $storedPassword)) {
                require('function_files/session.php');
                setSession($row['ID']);

                if($remember) {
                    require('function_files/RememberMe.php');
                    setRememberMe($remember);
                }

                http_response_code(200);
                $response = array("success" => true, "banned" => false);
            }else{
                $response = array("success" => false, "banned" => false);
            }
        }
    }
    $con->close();
    return $response;
}