<?php
    if(isset($_SESSION['loggedIn'])){
        $firstname = $_SESSION['firstname'];
        $lastname = $_SESSION['lastname'];
    }else{
        // Gestione dell'errore
    }
?>