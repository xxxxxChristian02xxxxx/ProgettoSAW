<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_COOKIE['ReMe'])) {
        //fa qualcosa: query per verificare se esiste
        require("connection.php");
        $cookie_val = $_COOKIE['ReMe'];
        $decodedata = json_decode($cookie_val, true);
        $token_val = $decodedata['token_value'];
        $firstname = $decodedata['firstname'];
        $lastname = $decodedata['lastname'];
        $query = "SELECT EXPIRE FROM USERS WHERE TOKEN = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $token_val);
        $stmt->execute();

        $res = $stmt->get_result();

        if ($res->num_rows) {
            $expire = $res->fetch_assoc();

            //Se scaduto rimanda alla pagina di login
            if (date(time()) > $expire['EXPIRE']) {
                header("Location: login.php");
            } else {
                $_SESSION['loggedIn'] = true;
                $_SESSION['firstname'] = $firstname;
                $_SESSION['lastname'] = $lastname;
            }
        }
        $stmt->close();
    }
    if($_SESSION['loggedIn']) {
        require('header.php');
        echo "<h2>Welcome $firstname $lastname</h2>";
    }
    else{
        header("Location: login.php");
    }
?>