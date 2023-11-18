<?php
if(isset($_SESSION['loggedIn'])) {
    require('session.php');

    //creo la connesione al DB
    require("connection.php");

    //Creazione del prepared statement per ottenere il privilegio dell'user
    $role_stmt = $con->prepare("SELECT ROLES FROM USERS WHERE FIRSTNAME = ? AND LASTNAME = ?");
    $role_stmt->bind_param('ss', $firstname, $lastname);

    //Esecuzione della query
    $role_stmt->execute();
    $role_stmt->bind_result($roles);
    $role_stmt->fetch();


    //controllo che la query sia andata a buon fine
    if ($role_stmt->affected_rows == 0) {
        echo "no rows inserted / updated / canceled";
    }

    // Chiusura del prepared statement
    $role_stmt->close();

    //chiusura connessione
    $con->close();

    if ($roles == 1) {
        echo "<a href=main.php>| Home </a>";
        echo "<a href=''>| Show profile </a>";
        echo "<a href=logout.php>| Logout | </a>";
        echo "<a href= editusers.php>| Edit Users |</a>";
    } else {
        echo "<a href=main.php>| Home </a>";
        echo "<a href=''>| Show profile </a>";
        echo "<a href=logout.php>| Logout | </a>";
    }
}
else{
    echo "<a href=index.php>| Home </a>";
    echo "<a href=registration.php>| Sign-up </a>";
    echo "<a href=login.php>| Sign-in | </a>";
}
?>