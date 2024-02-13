<?php
    session_start();

    require('function_files/connection.php');
    $con = connect();

    require('function_files/session.php');
    $session = getSession(true);
    $userId = $session['id'];

    $query = "SELECT FIRSTNAME, LASTNAME, EMAIL FROM USERS WHERE ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    $con->close();

    echo json_encode($data);