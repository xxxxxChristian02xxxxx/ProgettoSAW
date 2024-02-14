<?php
    session_start();

    if(!function_exists('requestProfileData')){
        function requestProfileData(){
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
        }
    }

if(!function_exists('updateProfileData')){
    function updateProfileData($firstname, $lastname, $email, $password){
        require('function_files/session.php');
        $session_variables = getSession(true);
        $userId = $session_variables['id'];

        require('function_files/connection.php');
        $con = connect();

        //Se è stato aggiornato il nome
        if ($firstname) {
            $query = "UPDATE USERS SET FIRSTNAME = ? WHERE ID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('si', $firstname, $userId);
            $stmt->execute();
        }

        //Se è stato aggiornato il cognome
        if ($lastname) {
            $query = "UPDATE USERS SET LASTNAME = ? WHERE ID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('si', $lastname, $userId);
            $stmt->execute();
        }

        //Se è stata aggiornata l'email
        if ($email) {
            $query = "UPDATE USERS SET EMAIL = ? WHERE ID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('si', $email, $userId);
            $stmt->execute();
        }

        //Se è stata aggiornata la password
        if ($password) {
            $password = password_hash($password, PASSWORD_DEFAULT);

            $query = "UPDATE USERS SET PASSWORD = ? WHERE ID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('si', $password, $userId);
            $stmt->execute();
        }
        $con->close();
    }
}

$data = json_decode(file_get_contents('php://input'), true);

if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'requestProfileData':
                requestProfileData();
                break;
            case 'updateProfileData':
                updateProfileData($data['json_data']['firstname'], $data['json_data']['lastname'], $data['json_data']['email'], $data['json_data']['password']);
                break;
        }
    }
    else{
        echo json_encode('azione non supportata');
    }
}