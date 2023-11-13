<?php
    if(isset($_SESSION['loggedIn'])){
        $id = $_SESSION['id'];
        $firstname = $_SESSION['firstname'];
        $lastname = $_SESSION['lastname'];
        $email = $_SESSION['email'];
        $password = $_SESSION['password'];
        $roles = $_SESSION['roles'];
        $banned = $_SESSION['banned'];
        $remember = $_SESSION['remember'];
    }else{
        // Gestione dell'errore
    }
?>