<?php
    require ('session.php');
    //set cookie se il rememberme è settato su true
    if ($remember) {
        $expire = time() + ((60 * 60 * 24) * 7);
        $salt = "%salt&/";
        //creo un token key random per non risalire alle credenziali dell'utente dal cookie
        //per rendere la proteine del cookie piu forte ci metto il sale

        //faccio hash cosicchè la chiave e il valore del mio cookie, essendo che contengono dati sensibili, vengano encriptati in modo pseudorandomico
        $token_key = hash('sha256', (time() . $salt));
        $token_value = hash('sha256', ("logged_in" . $salt));

        $sessiondata = json_encode(['token_value' => $token_value, 'firstname' => $firstname, 'lastname' => $lastname]);
        setcookie('ReMe', $sessiondata, $expire, '/');
        $expire = date("Y-m-d", $expire);
        require("connection.php");

        $query = "SELECT ID FROM USERS WHERE EMAIL=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $stmt->bind_result($id);
        $stmt->fetch();

        $stmt->close();
        // Preparazione della query con prepared statement
        $query = "UPDATE USERS SET REMEMBER = '1', TOKEN=?, EXPIRE=? WHERE ID=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ssi', $token_value, $expire, $id);

        // Assegnazione dei valori ai parametri e esecuzione della query
        //$token_key = $row['token_key'];
        //$token_value = $row['token_value'];
        //$id = $row['id'];
        $stmt->execute();

        $stmt->close();
    }
?>

