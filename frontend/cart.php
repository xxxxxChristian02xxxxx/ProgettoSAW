<?php

session_start();

//Verifica se impostato un cookie
include('../backend/function_files/verifyCookie.php');
verifyCookie();
//Aggiunta dell'header
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="../cart.css">

</head>
<body>
<div class="editUser">
    <h1>Cart:</h1>
    <div class="Informations">
        <div class="info">
            <p id="yourMoney" class="info"></p>
        </div>
        <div class="info">
            <p id="totalPrice" class="info"></p>
        </div>
    </div>

    <table class="dataTable" id="cartTable">
        <thead>
        <th>FLOWER</th>
        <th>QUANTITY</th>
        <th>TOTAL PRICE</th>
        </thead>
        <tbody></tbody>
    </table>
<div id="commands">
    <button id="buy" class="command-button">Buy</button>
    <button id="empty" class="command-button">Empty</button>
</div>
    <div id="pagination"></div>
    <script src="../js/cart.js"> var money = 0;
    var price = 0;
    </script>

</div>
</body>
</html>