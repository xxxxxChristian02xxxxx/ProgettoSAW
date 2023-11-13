<?php
session_start();
if(isset($_SESSION["loggedIn"])) {
    session_destroy();
    setcookie('ReMe',time()-(9000));
    header("Location: index.php");
    exit();

}
?>