<?php
session_start();
if(!isset($_SESSION['loggedIn'])) {
    header("Location: ../../frontend/index.html");
}
require('connection.php');
function promoteDemote($email) {
    $con = connect();

    $query = "UPDATE USERS SET ROLES = !ROLES WHERE EMAIL = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    if($stmt->affected_rows === 1){
        $query = "SELECT ROLES FROM USERS WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $con->close();

        header('Content-Type: application/json');
        echo json_encode($data['ROLES']);
    }
    else{
        echo('Something went wrong with the query result');
    }
}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    require('session.php');
    if($_SESSION['loggedIn'] && $_SESSION['role']) {
        if (isset($data['action']) && $data['action'] === 'promoteDemote') {
            promoteDemote($data['email']);
        } else {
            echo json_encode('Unsupported action');
        }
    }
    else{
        echo json_encode("You can't promote or demote users, you're not an admin");
    }
}