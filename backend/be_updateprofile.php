<?php
session_start();
include("function_files/inputCheck.php");
function requestProfileData(){
    require('function_files/connection.php');
    $con = connect();

    require('function_files/session.php');

    $query = "SELECT FIRSTNAME, LASTNAME, EMAIL FROM USERS WHERE ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows === 1){
        $data = $result->fetch_assoc();
        $sanitized_data = array_map('htmlspecialchars', $data);

        $con->close();

        echo json_encode($sanitized_data);
    }
}

function updateProfileData($firstname, $lastname, $email, $password){
    require('function_files/session.php');

    require('function_files/connection.php');
    $con = connect();

    $con->close();
    $query = "UPDATE USERS SET FIRSTNAME = ?, LASTNAME = ?, EMAIL = ?, PASSWORD = ? WHERE ID = ?";

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $con->prepare($query);
    $stmt->bind_param('ssssi', $firstname, $lastname, $email, $password, $_SESSION['id']);
    $stmt->execute();

    $con->close();
}

$data = json_decode(file_get_contents('php://input'), true);
error_log(print_r($data, true));
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {

    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'requestProfileData':
                requestProfileData();
                break;
            case 'updateProfileData':
                if(!inputMailcheck($data['data']['email'])){
                    echo json_encode('no valid email');
                }
                updateProfileData($data['data']['firstname'], $data['data']['lastname'], $data['data']['email'], $data['data']['password']);
                break;
        }
    }
    else{
        echo json_encode('Unsupported action');
    }
}