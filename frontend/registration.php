<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign-up</title>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../form.css">
    <!-- SPOSTATO IN REGISTRATION.JS-->
</head>

<body>
<div id="header">
    <script>
        $(function() {
            $("#header").load("public_header.html");
        });
    </script>
</div>
<div class="PageRegistration">
    <div class="headerRegistration">
        <h1>User Registration</h1>
    </div>
    <div class="RegistrationForm">
        <form id="UserRegistration" action="registration.php" method="POST">
            <div class="Firstname">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstname">
                <span id="firstnameError" class="error"></span>
            </div>
            <div class="Lastname">
                <label for="lastname">Lastname:</label>
                <input type="text"  name="lastname">
                <span id="lastnameError" class="error"></span>
            </div>
            <div class="Email">
                <label for="email">Email:</label>
                <input type="email" name="email">
                <span id="emailError" class="error"></span>
            </div>
            <div class="Password">
                <label for="pass">Password:</label>
                <input type="password" name="pass">
                <span id="passwordError" class="error"></span>
            </div>
            <div class="ConfirmPassword">
                <label for="confirm">Confirm password:</label>
                <input type="password" name="confirm">
                <span id="confirmError" class="error"></span>
            </div>
            <div id="Submit">
                <input type="submit" value="Sign-up">
            </div>
        </form>
    </div>
    <div id="errorMessages" class="error"></div>
</div>
<script src="../js/emailVerify.js"></script>
<script src="../js/registration.js"></script>
</body>
</html>

