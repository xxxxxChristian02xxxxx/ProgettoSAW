<?php
session_start();
if(!function_exists('banUnban')){
    function banUnban($email){
        require('session.php');
        $session_variables = getSession(true);

        require('connection.php');
        $con = connect();

        $query = "UPDATE USERS SET BANNED = !BANNED WHERE EMAIL = ? AND ROLES = 0";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $query = "SELECT BANNED FROM USERS WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        header('Content-Type: application/json');
        echo json_encode($data['BANNED']);
    }
}
if(!function_exists('deleteUser')){
    function deleteUser($email){


        require('session.php');
        $session_variables = getSession(true);

        require('connection.php');
        $con = connect();

        $query = "DELETE FROM USERS WHERE EMAIL=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $query = "SELECT * FROM USERS"; // query
        $stmt = $con->prepare($query); // execute query
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();

        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }

        $con->close();
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action']) ){
        switch ($data['action']){
            case 'banUnban':
                banUnban($data['email']);
                break;
            case 'deleteUsers':
                deleteUser($data['email']);
                break;
        }
    }
    else{
        echo json_encode('azione non supportata');
    }
}