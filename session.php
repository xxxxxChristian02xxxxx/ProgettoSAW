<?php
    if(isset($_SESSION['loggedIn'])){
        $email = $_POST['email'];
        $email = trim($email);
        $password = $_POST['pass'];
        $password = trim($password);
        $remember = $_POST['rememberme'];
    }else{
        header("location: login.php");
    }
?>