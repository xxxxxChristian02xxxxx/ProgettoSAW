<?php
session_start();
    //verifica della sessione
    require ('session.php');

    //set cookie se il rememberme è settato su true
    if (!empty(($_SESSION['rememberme']))) {

        $expires = time() + ((60 * 60 * 24) * 7);
        $salt = "%salt&/";
        //creo un token key random per non risalire alle credenziali dell'utente dal cookie
        //per rendere la proteine del cookie piu forte ci metto il sale

        //faccio hash cosicchè la chiave e il valore del mio cookie, essendo che contengono dati sensibili, vengano encriptati in modo pseudorandomico
        $token_key = hash('sha256', (time() . $salt));
        $token_value = hash('sha256', ("logged_in" . $salt));
        setcookie('ReMe', $token_key . ':' . $token_value, $expires, '/');
        require("connection.php");

        // Preparazione della query con prepared statement
        $query = "UPDATE USERS SET token_key=?, token_value=? WHERE ID=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ssi', $token_key, $token_value, $id);

        // Assegnazione dei valori ai parametri e esecuzione della query
        $token_key = $row['token_key'];
        $token_value = $row['token_value'];
        $id = $row['id'];
        $stmt->execute();




    }

?>

