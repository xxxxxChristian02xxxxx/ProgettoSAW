<?php
session_start();
if(!isset($_SESSION['loggedIn']) &&  $_SESSION['role']  != 1) {
    header("Location: ../../frontend/index.html");
}
function banUnban($email){
    require('connection.php');
    $con = connect();

    $query = "UPDATE USERS SET BANNED = !BANNED WHERE EMAIL = ? AND ROLES = 0";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    if($stmt->affected_rows === 1){
        $query = "SELECT BANNED FROM USERS WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $con->close();

        header('Content-Type: application/json');
        echo json_encode($data);
    }
    else{
        echo('Something went wrong with the query result');
    }

}


$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if($_SESSION['loggedIn'] && $_SESSION['role']){
        if(isset($data['action']) && $data['action'] === 'banUnban'){
            banUnban($data['email']);
        }
        else{
            echo json_encode('Unsupported action');
        }
    }
    else{
        echo json_encode("You can't ban or unban users, you're not an admin");
    }
}