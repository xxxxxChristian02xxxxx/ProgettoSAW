<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    require ('../backend/function_files/inputCheck.php');

if(!function_exists('checkPresenceEmail')) {
    function checkPresenceEmail($email)
    {
        require("function_files/connection.php");
        $con = connect();
        if(!inputMailcheck($email)){
            echo json_encode('no valid email');
        }


        $query = "SELECT EMAIL FROM USERS WHERE EMAIL=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $emailAlreadyUsed['present'] = true;
        } else {
            $emailAlreadyUsed['present'] = false;
        }

        header('Content-Type: application/json');
        echo json_encode($emailAlreadyUsed);
    }
}

$data = json_decode(file_get_contents('php://input'), true);

if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action']) && $data['action'] === 'checkPresenceEmail') {
        checkPresenceEmail($data['email']);
    }
    else{
        echo json_encode('Unsupported action');
    }
}