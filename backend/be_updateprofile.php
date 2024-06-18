<?php
session_start();
require("function_files/test_session.php");
include("function_files/inputCheck.php");
require_once('function_files/connection.php');

function updateProfileData($firstname, $lastname, $email){
    $con = connect();

    $query = "UPDATE USERS SET FIRSTNAME = ?, LASTNAME = ?, EMAIL = ? WHERE ID = ?";

    $stmt = $con->prepare($query);
    $stmt->bind_param('sssi', $firstname, $lastname, $email, $_SESSION['id']);
    $stmt->execute();
    if($stmt->affected_rows === 1) {
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['email'] = $email;
    }
    $con->close();
}

$data = json_decode(file_get_contents('php://input'), true);

if($data && $_SERVER["REQUEST_METHOD"] === "POST") {

    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'requestProfileData':
                $res = [
                    "FIRSTNAME" => $_SESSION['firstname'],
                    "LASTNAME" => $_SESSION['lastname'],
                    "EMAIL" => $_SESSION['email']
                ];
                $res = array_map('htmlspecialchars', $res);
                echo json_encode($res);
                break;
            case 'updateProfileData':
                if(!inputMailcheck($data['data']['email'])){
                    echo json_encode(array('error'=>'no valid email'));
                }

                updateProfileData($data['data']['firstname'], $data['data']['lastname'], $data['data']['email']);
                echo json_encode(array('success'=>'we rope'));
                break;
        }
    }
    else{
        echo json_encode('Unsupported action');
    }
}