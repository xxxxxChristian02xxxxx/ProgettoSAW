<?php
session_start();
//Verifica che la sessione sia attiva
include('../backend/function_files/session.php');
//Aggiunta dell'header
include('header.php');

$session = getSession(true);
echo "<h2>Welcome " . $session['firstname'] . " " . $session['lastname'] .  " </h2>" ;
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <title>My Garden</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
</head>
<body>





</body>
<script>

    fetch("../backend/be_mygarden.php")
        .then(response => {
            return response.json();
        })
        .then(data => {
            
        })
        .catch(error => {
            console.error("Si è verificato un errore: ", error);
        });

</script>
</html>