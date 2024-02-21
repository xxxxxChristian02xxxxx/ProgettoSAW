<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shop</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link href="../shop.css" rel="stylesheet" type="text/css">
    <script src ="../js/shop.js"></script>
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
<header>
    <div id = "Shop_NavBar">
        <div class="left_button">
            <form id="search_form" method="get">
                <label for="search">Search: </label>
                <input type="text" id="search" name="search" placeholder="Search...">
                <input type="submit" class = "shop_button" value="Go">
            </form>
        </div>
        <div class="right_button">
            <h3 id="Wallet">Wallet: </h3>
            <h3 id="MyMoney">0</h3>
            <a id="cart" class = "shop_button" href="cart.php" >Cart</a>
        </div>
    </div>
</header>
<main id="shop-container">

</main>

<div id="popUp" class="hidden">
    <div id="popUpContent">
    </div>
</div>

<script>
    let items = [];

    window.addEventListener('load', () => {
        const shopContainer = document.getElementById('shop-container');
        fetch("../backend/be_shop.php?flowers=1",{
            method: 'GET',
        })
            .then(response => {
                return response.json();
            })
            .then(data => {
                items = data;
                appendPlantsToContainer(items, shopContainer);
            })
            .catch(error => {
                console.error("Si è verificato un errore: ", error);
            });
        let money = getMoney();
    });

    document.getElementById('search_form').addEventListener('submit', (event) => {
        event.preventDefault();
        const search = document.getElementById('search').value;
        if (search === '') {
            alert('Empty search');
            return;
        }
        fetch(`../backend/be_shop.php?search=${search}`,{
            method: 'GET',
        })
            .then(response => {
                return response.json();
            })
            .then(data => {
                items = data;
                const shopContainer = document.getElementById('shop-container');
                if (items.length === 0) {
                    alert('No items found');
                }else{
                    appendPlantsToContainer(items, shopContainer);
                }
            })
            .catch(error => {
                console.error("Si è verificato un errore: ", error);
            });
    });

</script>

</body>
</html>