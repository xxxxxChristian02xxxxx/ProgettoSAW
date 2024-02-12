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

        //creazione prepared statemet per prelevare tutta la tabella
        $query = "SELECT * FROM USERS"; // query
        $stmt = $con->prepare($query); // execute query
        $stmt->execute();
        $result = $stmt->get_result();

        $data = array();

        header('Content-Type: application/json');
        if($result->num_rows>0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }

        $con->close();

        echo json_encode($data);
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
        echo json_encode('azione non supportata');

    }
}