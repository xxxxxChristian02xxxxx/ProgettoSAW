<?php
if(isset($_SESSION['loggedIn'])) {

    $email = $_POST['email'];
    $email = trim($email);
    $password = $_POST['pass'];
    $password = trim($password);
    require('session.php');

    //creo la connesione al DB
    require("connection.php");

    //Sanificazione input
    $email = $con->real_escape_string($email);

    //Creazione del prepared statement per ottenere il privilegio dell'user
    $role_stmt = $con->prepare("SELECT ROLES FROM USERS WHERE MAIL =?");
    $role_stmt->bind_param('s', $email);

    //Esecuzione della query
    $role_stmt->execute();
    $role_stmt->bind_result($roles);
    $role_stmt->fetch();
    echo $role_stmt." ".$roles;


    //controllo che la query sia andata a buon fine
    if ($role_stmt->affected_rows == 0){
        echo "no rows inserted / updated / canceled";
    }

    // Chiusura del prepared statement
    $role_stmt->close();

    //chiusura connessione
    $con->close();

    if($roles == 1){
        echo "<a href=main.php>| Home </a>";
        echo "<a href=''>| Show profile </a>";
        echo "<a href=logout.php>| Logout | </a>";
        echo "<a href= editusers.php>| Edit Users |</a>";
    }else {
        echo "<a href=main.php>| Home </a>";
        echo "<a href=''>| Show profile </a>";
        echo "<a href=logout.php>| Logout | </a>";
    }

    //verifica che il cookie sia statto messo
    if(isset($_COOKIE['ReMe'])) {
        //se il cookie continee un :
        if(strstr($cookie,":")) {
            $cookie = $_COOKIE['ReMe'];
            $parts = explde(":", $cookie);
            $token_key = $parts[0];
            $token_value = $parts[1];

            $stm = $con->prepare("SELECT * FROM USERS WHERE TOKEN_KEY =?");
            $stm->bind_param('s', $token_key);

            //Esecuzione della query
            $stm->execute();
            $stm->bind_result($rows);
            $stm->fetch();


            if($con->affected_rows == 0){
                //Utente registrtato correttamente, posso chiudere la connessione
                $con->close();
                echo "non  a buon fine";

            }
            //non se sia giusto
            $row = $rows[0];
            if($token_value ==$rows['token_value']){
                $_SESSION['loggedIn'] = $row;
            }

        }
    }



}
else{
    echo "<a href=index.php>| Home </a>";
    echo "<a href=registration.php>| Sign-Up </a>";
    echo "<a href=login.php>| Sign-In | </a>";
}
?>