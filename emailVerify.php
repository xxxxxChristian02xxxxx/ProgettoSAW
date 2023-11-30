<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $json_data = file_get_contents('php://input');
    $email = json_decode($json_data, true);
    $email = $email['email'];
    require("function_files/connection.php");
    $con = connect();

    $query = "SELECT EMAIL FROM USERS WHERE EMAIL=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $emailAlreadyUsed = true;
    } else {
        $emailAlreadyUsed = false;
    }

    header('Content-Type: application/json');
    echo json_encode($emailAlreadyUsed);
?>