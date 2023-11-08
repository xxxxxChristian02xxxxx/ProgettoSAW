<?php
session_start();
if(isset($_SESSION['loggedIn'])){
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    echo "<h2>Welcome $firstname $lastname";
}
?>