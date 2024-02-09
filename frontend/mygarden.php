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
    <link href="../dressing_garden.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <!-- Header content here -->
</header>
<div class="field" id="plants-container"></div>
<script src ="../js/mygarden.js"></script>
<footer>
    <!-- Footer content here -->
</footer>



</body>
<script>

    let plants = [];
        /*{
            id: 1,
            name: "Monstera Deliciosa",
            price: 50.00,
            urlimage: "../images/Fiori_1.jpg"
        },
        {
            id: 2,
            name: "Fiddle Leaf Fig",
            price: 75.00,
            urlimage: "../images/Fiori_2.png"
        },
        {
            id: 3,
            name: "Fiddle Leaf Fig",
            price: 75.00,
            urlimage: "../images/Fiori_2.png"
        },
    ];
    const plantsContainer = document.getElementById('plants-container');
    appendPlantsToContainer(plants, plantsContainer);
*/
    fetch("../backend/be_mygarden.php")
        .then(response => {
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