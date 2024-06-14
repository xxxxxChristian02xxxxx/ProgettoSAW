<!DOCTYPE html>
<html lang="en">
<head>
    <title>My profile</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/form.css">

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

    <div class="PageProfileUser">
        <div class="HeaderShowProfileUser">
            <h1>My profile</h1>
        </div>
        <div class="ShowUserForm">
            <div class="Firstname">
                <p >Firstname: </p>
                <p id="firstname"></p>
            </div>

            <div class="Lastname">
                <p >Lastname: </p>
                <p id="lastname"></p>
            </div>

            <div class="Email">
                <p >Email:  </p>
                <p id="email"></p>
            </div>

            <div class="Money">
                <p >Money: </p>
                <p id="money"></p>
            </div>

            <div class="TimeStudied">
                <p >Total Time Studied: </p>
                <p id="timestudied"></p>
            </div>

            <div id="NumberPlants">
                <p >Number Plants Purchased: </p>
                <p id="plantpurchased"></p>
            </div>
        </div>
    </div>
</main>
<footer id="footer">
    <?php
    include('footer.html');
    ?>
</footer>
    <script src="../js/show_profile.js"></script>
</body>
</html>