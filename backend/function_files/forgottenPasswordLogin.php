<?php
if(!function_exists('checkPresenceEmail')){
    function checkPresenceEmail($email){
        require("connection.php");
        $con = connect();

        $query = "SELECT EMAIL FROM USERS WHERE EMAIL=?";
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
}
if(!function_exists('updatePasswordLogin')){
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

        header('Content-Type: application/json');
        if($stmt->affected_rows === 1){
            echo json_encode("true");
        }
        else{
            echo json_encode("true");
        }

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
    }else{
        echo json_encode('azione non supportata');
        }
    }