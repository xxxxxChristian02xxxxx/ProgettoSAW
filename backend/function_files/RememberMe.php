<?php
if(!function_exists('setRememberMe')) {
    function setRememberMe($remember)
    {
        //set cookie se il rememberme è settato su true
        if ($remember) {
            require('session.php');
            $session_variables = getSession(true);

            $expire = time() + ((60 * 60 * 24) * 7);
            $salt = "%salt&/";
            //creo un token key random per non risalire alle credenziali dell'utente dal cookie
            //per rendere la protezione del cookie piu forte ci metto il sale

            //faccio hash cosicchè il valore del mio cookie, essendo che contiene dati sensibili, venga encriptato in modo pseudorandomico
            $token_value = hash('sha256', ("logged_in" . $salt));

            // Uso json_encode perchè i cookie possono memorizzare solo delle stringhe, quindi di per sè non possono memorizzare
            // array associativi -> per memorizzare più informazioni in un singolo cookie lo converto in una stringa
            $sessiondata = json_encode(['token_value' => $token_value, 'id' => $session_variables['id']]);
            // '/' -> indica che il cookie è valido per tutto il sito
            setcookie('ReMe', $sessiondata, $expire, '/');
            $expire = date("Y-m-d", $expire);

            include("connection.php");
            $con = connect();

            // Preparazione della query con prepared statement
            $query = "UPDATE USERS SET REMEMBER = '1', TOKEN=?, EXPIRE=? WHERE ID=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ssi', $token_value, $expire, $session_variables['id']);
            $stmt->execute();

            $stmt->close();
        }
    }
}


