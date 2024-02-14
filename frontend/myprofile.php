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

    <link href="../myprofile.css" rel="stylesheet" type="text/css">

    <script src="../js/emailVerify.js"></script>
</head>

<body>
<div class="UpdateForm">
    <h1>My profile</h1>
    <form id="UserUpdate" action="myprofile.php" method="POST">
        <label for="firstname">Firstname:</label>
        <input type="text" id="firstname" name="firstname"><br>

        <label for="lastname">Lastname:</label>
        <input type="text" id="lastname" name="lastname"><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br>
        <span id="emailError" class="error"></span>

        <label for="pass">New password:</label>
        <input type="password" id="pass" name="pass"><br>

        <label for="confirm">Confirm new password:</label>
        <input type="password" id="confirm" name="confirm"><br>

        <input type="submit" value="Update">
    </form>
    <script src="../js/myProfile.js"></script>
</div>
</body>
</html>