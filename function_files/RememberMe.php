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
            //per rendere la proteine del cookie piu forte ci metto il sale

            //faccio hash cosicchè la chiave e il valore del mio cookie, essendo che contengono dati sensibili, vengano encriptati in modo pseudorandomico
            $token_key = hash('sha256', (time() . $salt));
            $token_value = hash('sha256', ("logged_in" . $salt));

            $sessiondata = json_encode(['token_value' => $token_value, 'id' => $session_variables['id']]);
            setcookie('ReMe', $sessiondata, $expire, '/');
            $expire = date("Y-m-d", $expire);

            include("function_files/connection.php");
            $con = connect();

            // Preparazione della query con prepared statement
            $query = "UPDATE USERS SET REMEMBER = '1', TOKEN=?, EXPIRE=? WHERE ID=?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ssi', $token_value, $expire, $session_variables['id']);

            // Assegnazione dei valori ai parametri e esecuzione della query
            //$token_key = $row['token_key'];
            //$token_value = $row['token_value'];
            //$id = $row['id'];
            $stmt->execute();

            $stmt->close();
        }
    }
}
?>

