<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_COOKIE['ReMe'])) {
        //fa qualcosa: query per verificare se esiste
        include('backend/function_files/connection.php');
        $con = connect();


        $cookie_val = $_COOKIE['ReMe'];
        $decodedata = json_decode($cookie_val, true);
        $token_val = $decodedata['token_value'];
        $id = $decodedata['id'];
        $query = "SELECT EXPIRE FROM USERS WHERE TOKEN = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $token_val);
        $stmt->execute();

        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $expire = $res->fetch_assoc();

            //Se scaduto rimanda alla pagina di login
            if (date(time()) > $expire['EXPIRE']) {
                header("Location: frontend/login.php");
            } else {
                include('backend/function_files/session.php');
                setSession($id);
            }
        }else{
            //todo: create error
        }
        $stmt->close();
    }

    //Verifica che la sessione sia attiva
    include('backend/function_files/session.php');
    include('frontend/header.php');

?>