<?php
session_start();
if(!function_exists('modifyMoney')){
    function modifyMoney($email, $money){
        require('session.php');
        $session_variables = getSession(true);

        require('connection.php');
        $con = connect();

        $query = "UPDATE USERS SET MONEY = ?  WHERE EMAIL = ? AND ROLES != 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param("is", $money,$email);
        $stmt->execute();

        // ottengo il valore updatato dal db
        $query = "SELECT MONEY FROM USERS WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();


        $data = $result->fetch_assoc();
        $updatedMoney = $data['MONEY'];

        header('Content-Type: application/json');
        echo json_encode($updatedMoney);
    }
}
if(!function_exists('resetMoney')){
    function resetMoney($email){
        require('session.php');
        $session_variables = getSession(true);

        require('connection.php');
        $con = connect();

        $query = "UPDATE USERS SET MONEY = 0  WHERE EMAIL = ? AND ROLES != 1";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();

        if($stmt->affected_rows === 1){
            // ottengo il valore updatato dal db
            $query = "SELECT MONEY FROM USERS WHERE EMAIL = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();


            $data = $result->fetch_assoc();
            $updatedMoney = $data['MONEY'];

            header('Content-Type: application/json');
            echo json_encode($updatedMoney);
        }
        else{
            echo('Something went wrong with the query result');
        }
    }
}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'modifyMoney':
                modifyMoney($data['email'],$data['money']);
                break;
            case 'resetMoney':
                resetMoney($data['email']);
                break;
        }
    }else{
        echo json_encode('Unsupported action');
    }
}