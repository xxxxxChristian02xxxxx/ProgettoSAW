<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cart</title>
    <link rel="stylesheet" type="text/css" href="../css/cart.css">
    <link rel="stylesheet" type="text/css" href="../css/editTable.css">
</head>
<body>
<?php
session_start();

//Verifica se impostato un cookie
include('../backend/function_files/verifyCookie.php');
verifyCookie();
//Aggiunta dell'header
include('header.php');
?>
<main class="wrapper">
    <div class="cart">
        <h1>Cart</h1>
        <div class="Informations">
            <div class="info">
                <h3 id="yourMoney" class="info"></h3>
            </div>
            <div class="info">
                <h3 id="totalPrice" class="info"></h3>
            </div>
        </div>

        <table class="dataTable" id="cartTable">
            <thead>
            <tr>
                <th>FLOWER</th>
                <th>QUANTITY</th>
                <th>TOTAL PRICE</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    <div id="commands">
        <button id="buy" class="command-button">Buy</button>
        <button id="empty" class="command-button">Empty</button>
    </div>
        <div id="pagination"></div>
        <script src="../js/cart.js">
            var money = 0;
            var price = 0;
        </script>

    </div>
</main>
</body>
</html>