<?php
session_start();

require ("connection.php");

if(isset($_COOKIE['ReMe'])){
    //fa qualcosa: query per verificare se esiste
    $cookie_val = $_COOKIE['ReMe'];
    $decodedata = json_decode($cookie_val, true);
    $token_val = $decodedata['token_value'];
    $cookie_data = $decodedata['data'];
    $query = "SELECT * FROM USERS WHERE TOKEN='$token_val'";
    $res = $con->query($query);
    $row = $res->fetch_assoc();
    //Se non esiste o scaduto rimanda alla pagina di login
    if(date(time())>$row['EXPIRE']){
        header("Location: login.php");
    }
    else{
        $_SESSION['loggedIn'] = true;
        $_SESSION['id'] = $cookie_data['id'];
        $_SESSION['firstname'] = $cookie_data['firstname'];
        $_SESSION['lastname'] = $cookie_data['lastname'];
        $_SESSION['email'] = $cookie_data['email'];
        $_SESSION['password'] = $cookie_data['password'];
        $_SESSION['roles'] = $cookie_data['roles'];
        $_SESSION['banned'] = $cookie_data['banned'];
    }
}
if(isset($_SESSION['loggedIn'])){
    //require ("header.php");
    $firstname = $_SESSION['firstname'];
    $lastname = $_SESSION['lastname'];
    echo "<h2>Welcome $firstname $lastname";
}
?>