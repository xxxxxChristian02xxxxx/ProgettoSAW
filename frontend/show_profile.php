<!DOCTYPE html>
<html lang="en">
<head>
    <title>My profile</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../form.css">

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
                <span>
                        <p id="firstname"></p>
                    </span>
            </div>

            <div class="Lastname">
                <p >Lastname: </p>
                <span>
                        <p id="lastname"></p>
                    </span>
            </div>

            <div class="Email">
                <span>
                <p >Email:  </p>
                <span>
                    <p id="email"></p>
                </span>
                    </span>
            </div>

            <div class="Money">
                <p >Money: </p>
                <span>
                    <p id="money"></p>
                </span>
            </div>

            <div class="TimeStudied">
                <p >Total Time Studied: </p>
                <span>
                        <p id="timestudied"></p>
                    </span>

            </div>

            <div id="NumberPlants">
                <p >Number Plants Purchased: </p>
                <span>
                        <p id="plantpurchased"></p>
                    </span>
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