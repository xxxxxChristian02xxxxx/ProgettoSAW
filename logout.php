<?php
    session_start();

    session_destroy();

    $_SESSION["loggedIn"] = false;

    require("connection.php");
    if (isset($_COOKIE['ReMe'])) {
        //fa qualcosa: query per verificare se esiste
        $cookie_val = $_COOKIE['ReMe'];
        $decodedata = json_decode($cookie_val, true);
        $token_val = $decodedata['token_value'];
        $cookie_data = $decodedata['data'];

        $firstname = $cookie_data['firstname'];
        $lastname = $cookie_data['lastname'];

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

    header("Location: index.php");
    exit();
?>