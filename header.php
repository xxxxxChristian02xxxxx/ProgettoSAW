<?php
if(isset($_SESSION['loggedIn'])) {

    //creo la connesione al DB
    require("connection.php");

    //Query per ottenere il privilegio dell'user
    $email = $con->real_escape_string($email);

    //Creazione del prepared statement
    $role_stmt = $con->prepare("SELECT ROLES FROM USERS WHERE MAIL =?");
    $role_stmt->bind_param('s', $email);

    //Esecuzione della query
    $role_stmt->execute();
    $role_stmt->bind_result($roles);
    $role_stmt->fetch();

    //controllo che la query sia andata a buon fine
    if ($role_stmt->num_rows === 0){
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
}
else{
    echo "<a href=index.php>| Home </a>";
    echo "<a href=registration.php>| Sign-Up </a>";
    echo "<a href=login.php>| Sign-In | </a>";
}
?>