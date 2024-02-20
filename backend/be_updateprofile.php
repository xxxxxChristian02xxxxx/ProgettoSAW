<?php
    session_start();

    if(!function_exists('requestProfileData')){
        function requestProfileData(){
            require('function_files/connection.php');
            $con = connect();

            require('function_files/session.php');
            $session = getSession(true);
            $userId = $session['id'];
            error_log($userId);
            $query = "SELECT FIRSTNAME, LASTNAME, EMAIL FROM USERS WHERE ID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 1){
                $data = $result->fetch_assoc();

                $con->close();

                echo json_encode($data);
            }
        }
    }

if(!function_exists('updateProfileData')){
    function updateProfileData($firstname, $lastname, $email, $password){
        require('function_files/session.php');
        $session_variables = getSession(true);
        $userId = $session_variables['id'];

        require('function_files/connection.php');
        $con = connect();

        $query = "UPDATE USERS SET ";
        $params = array();

        //Se è stato aggiornato il nome
        if ($firstname) {
            $query .= "FIRSTNAME = ?, ";
            $params[] = $firstname;
        }

        //Se è stato aggiornato il cognome
        if ($lastname) {
            $query .= "LASTNAME = ?, ";
            $params[] = $lastname;
        }

        //Se è stata aggiornata l'email
        if ($email) {
            $query .= "EMAIL = ?, ";
            $params[] = $email;
        }

        //Se è stata aggiornata la password
        if ($password) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query .= "PASSWORD = ?, ";
            $params[] = $password;
        }

        if(!empty($params)){
            //Rimozione dell'ultima virgola e spazio dalla query
            $query = rtrim($query, ", ");

            $query .= " WHERE ID = ?";
            $params[] = $userId;

            $stmt = $con->prepare($query);
            $type = str_repeat('s', count($params)-1);
            $stmt->bind_param($type.'i', ...$params);
            $stmt->execute();
        }

        $con->close();
    }
}

$data = json_decode(file_get_contents('php://input'), true);
error_log("sono qui");
error_log(print_r($data, true));
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'requestProfileData':
                requestProfileData();
                break;
            case 'updateProfileData':
                updateProfileData($data['data']['firstname'], $data['data']['lastname'], $data['data']['email'], $data['data']['password']);
                break;
        }
    }
    else{
        echo json_encode('Unsupported action');
    }
}