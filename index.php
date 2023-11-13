<?php
session_start();

//funzione per rimanere non loggati
    if(empty($_SESSION["loggedIn"])){
        header("location: login.php");
        die;
    }

?>

<!DOCTYPE html>
<html lang="en">

<body>
    <?php
    require('header.php');
    ?>

    <h1>This is the homepage of our website</h1>
</body>
</html>