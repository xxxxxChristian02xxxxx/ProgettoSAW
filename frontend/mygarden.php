<?php
session_start();

//Verifica se impostato un cookie
include('../backend/function_files/verifyCookie.php');
verifyCookie();
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
    <link href="../dressing_garden.css" rel="stylesheet" type="text/css">
</head>
<body>

<div class="field" id="plants-container"></div>
<script src ="../js/mygarden.js"></script>




</body>
<script>

    let plants = [];


    fetch("../backend/be_mygarden.php")
        .then(response => {
            //  console.log("Response: ", response); // log the response
            // return response.text();
            return response.json();
        })
        .then(data => {
            plants = data; // store the data in the `plants` variable
            console.log("ok");
            console.log(plants);
            const plantsContainer = document.getElementById('plants-container');
            appendPlantsToContainer(plants, plantsContainer);
        })
        .catch(error => {
            console.error("Si è verificato un errore: ", error);
        });


</script>
</html>