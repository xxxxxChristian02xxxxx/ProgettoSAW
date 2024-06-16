<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require ('function_files/inputCheck.php');

$postData = file_get_contents("php://input");

$data = json_decode($postData, true);

if ($data && $_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($data['firstname']) && isset($data['lastname'])  && isset($data['email']) && isset($data['pass']) && isset($data['confirm'])) {

        $firstname = $data['firstname'];
        $firstname = trim($firstname);
        $lastname = $data['lastname'];
        $lastname = trim($lastname);
        $email = $data['email'];
        $email = trim($email);
        $password = $data['pass'];
        $password = trim($password);
        $confirm = $data['confirm'];
        $confirm = trim($confirm);

        if (!inputMailcheck($email)) {
            echo json_encode('no valid email');
        }

        $data = registration($firstname, $lastname, $email, $password, $confirm);
        echo json_encode($data);
    }
}

function registration($firstname, $lastname, $email, $password, $confirm){
    include("function_files/connection.php");
    $con = connect();

    if($password ===  $confirm){
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        return array("success" => false);
    }

    $query = "INSERT INTO USERS(ID, FIRSTNAME, LASTNAME, EMAIL, PASSWORD) VALUES (NULL, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssss', $firstname, $lastname, $email, $password);

    $stmt->execute();

    if ($stmt->affected_rows == 1) {
        http_response_code(200);
        $data = array("success" => true);
    }
    else {
        $data = array("success" => false);
    }
    $con->close();

    return $data;
}