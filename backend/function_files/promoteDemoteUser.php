<?php
session_start();
if(!function_exists('promoteDemote')) {
    function promoteDemote($email)
    {
        require('session.php');
        $session_variables = getSession(true);

        require('connection.php');
        $con = connect();

        $query = "UPDATE USERS SET ROLES = !ROLES WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $query = "SELECT ROLES FROM USERS WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode($data['ROLES']);

        $con->close();
    }
}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action']) && $data['action']==='promoteDemote'){
        promoteDemote($data['email']);
    }
    else{
        echo json_encode('azione non supportata');
    }
}