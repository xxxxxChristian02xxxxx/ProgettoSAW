<?php
function checkPresenceEmail($email){
    require("connection.php");
    $con = connect();

    $query = "SELECT * FROM USERS WHERE EMAIL=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $emailPresent['present'] = true;
    } else {
        $emailPresent['present'] = false;
    }

    header('Content-Type: application/json');
    echo json_encode($emailPresent);
}

function updatePasswordLogin($email, $password){

    require('connection.php');
    $con = connect();

    if ($password) {
        $pas = trim($password);
        $pass = password_hash($pas, PASSWORD_DEFAULT);
        $query = "UPDATE USERS SET PASSWORD = ? WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ss', $pass, $email);
        $stmt->execute();
    }
}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'checkPresenceEmail':
                checkPresenceEmail($data['email']);
                break;
            case 'updatePasswordLogin':
                updatePasswordLogin($data['email'], $data['password']);
                break;
        }
    }else
    {
        echo json_encode('Unsupported action');
    }
}