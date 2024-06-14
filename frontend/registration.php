<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign-up</title>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/form.css">
</head>

<body>
<header id="header">
    <script>
        $(function() {
            $("#header").load("public_header.html");
        });
    </script>
</header>
<main class="wrapper">
    <div class="PageRegistration">
        <div class="headerRegistration">
            <h1>User Registration</h1>
        </div>
        <div class="RegistrationForm">
            <form id="UserRegistration" action="registration.php" method="POST">
                <div class="Firstname">
                    <label for="firstname">Firstname:</label>
                    <input type="text" id="firstname" name="firstname">
                    <span id="firstnameError" class="error"></span>
                </div>
                <div class="Lastname">
                    <label for="lastname">Lastname:</label>
                    <input type="text" id="lastname" name="lastname">
                    <span id="lastnameError" class="error"></span>
                </div>
                <div class="Email">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                    <span id="emailError" class="error"></span>
                </div>
                <div class="Password">
                    <label for="pass">Password:</label>
                    <input type="password" id="pass" name="pass">
                    <span id="passwordError" class="error"></span>
                </div>
                <div class="ConfirmPassword">
                    <label for="confirm">Confirm password:</label>
                    <input type="password" id="confirm" name="confirm">
                    <span id="confirmError" class="error"></span>
                </div>
                <div id="Submit">
                    <input id="submitButton" type="submit" value="Sign-up">
                </div>
            </form>
        </div>
        <div id="errorMessages" class="error"></div>
    </div>
</main>
<footer id="footer">
    <script>
        $(function() {
            $("#footer").load("footer.html");
        });
    </script>
</footer>
<script src="../js/emailVerify.js"></script>
<script src="../js/registration.js"></script>
</body>
</html>