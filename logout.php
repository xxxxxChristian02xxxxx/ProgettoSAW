<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();

    session_destroy();

    $_SESSION["loggedIn"] = false;

    include('backend/function_files/connection.php');
    $con = connect();

    if (isset($_COOKIE['ReMe']) && $_COOKIE['ReMe'] !== null) {

        //fa qualcosa: query per verificare se esiste
        $cookie_val = $_COOKIE['ReMe'];
        $decodedata = json_decode($cookie_val, true);
        $token_val = $decodedata['token_value'];
        $cookie_data = $decodedata['data'];

        $firstname = $cookie_data['firstname'];
        $lastname = $cookie_data['lastname'];

        //todo: a very large problem  firstname + lastname are not unique keys
        $query = "SELECT TOKEN FROM USERS WHERE FIRSTNAME=? AND LASTNAME=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ss', $firstname, $lastname);
        $stmt->execute();

        $stmt->bind_result($token_val);
        $stmt->fetch();

        $stmt->close();

        // Preparazione della query con prepared statement
        $query = "UPDATE USERS SET TOKEN = '', EXPIRE = '0000-00-00' WHERE TOKEN=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s',$token_val);

        $stmt->execute();

        $stmt->close();

        setcookie('ReMe','', time()-3600, "/");

        unset($_COOKIE);
    }
    header("Location: frontend/index.php");
    exit();
?>