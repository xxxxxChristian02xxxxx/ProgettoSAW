<?php
session_start();


function deleteUser($email){
    require('connection.php');
    $con = connect();

    $query = "DELETE FROM USERS WHERE EMAIL=? AND ROLES = 0";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    require('session.php');
    
    if($_SESSION['loggedIn'] && $_SESSION['role']) {
        if (isset($data['action']) && $data['action'] === 'deleteUser') {
            deleteUser($data['email']);
        } else {
            echo json_encode('Unsupported action');
        }
    }
    else{
        echo json_encode("You can't delete users, you're not an admin");
    }
}