<?php
session_start();
require ('RememberMe.php');

//debug
echo $_COOKIE['ReMe'];

if(isset($_SESSION['loggedIn'])){
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    require ('header.php');
    echo "<h2>Welcome $firstname $lastname";



}
?>