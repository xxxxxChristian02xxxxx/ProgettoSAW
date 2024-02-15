<?php
session_start();

//Verifica se impostato un cookie
include('../backend/function_files/verifyCookie.php');
verifyCookie();
//Aggiunta dell'header
include('header.php');
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>My profile</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="../form.css">

    <script src="../js/emailVerify.js"></script>
</head>

<body>
<div class="PageUpdate">
    <div class="headerMyProfile">
        <h1>My profile</h1>
    </div>
    <div class="UpdateForm">
        <form id="UserUpdate" action="myprofile.php" method="POST">
            <div class="Firstname">
                <label for="firstname">Firstname:</label>
                <input type="text" id="firstname" name="firstname"><br>
            </div>

            <div class="Lastname">
                <label for="lastname">Lastname:</label>
                <input type="text" id="lastname" name="lastname"><br>
            </div>

            <div class="Email">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email"><br>
                <span id="emailError" class="error"></span>
            </div>

            <div class="Password">
                <label for="pass">New password:</label>
                <input type="password" id="pass" name="pass"><br>
            </div>

            <div class="ConfirmPassword">
                <label for="confirm">Confirm new password:</label>
                <input type="password" id="confirm" name="confirm"><br>
            </div>

            <div id="Submit">
                <input type="submit" value="Update">
            </div>

        </form>
    </div>
    <script src="../js/myProfile.js"></script>
</div>
</body>
</html>