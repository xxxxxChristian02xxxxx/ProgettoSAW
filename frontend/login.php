<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/form.css">

</head>

<body>
<header id="header">
    <script>
        $(function () {
            $("#header").load("public_header.html");
        });
    </script>
</header>
<main class="wrapper">
    <div class="PageLogin">
        <div class="headerLogin">
            <h1>Insert email and password and click Sign-in</h1>
        </div>
        <div class="LoginForm">
            <form id="UserLogin" action="login.php" method="POST">
                    <div class="Email">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email">
                    </div>
                    <div class="Password">
                        <label for="pass">Password:</label>
                        <input type="password" id="pass" name="pass">
                    </div>
                    <div id="Submit">
                        <input type="submit" value="Sign-in">
                    </div>
            </form>
            <div class="RememberMe">
                <label for="ReMe">Remember Me:</label>
                <input type="checkbox" id="ReMe" name="ReMe">
            </div>
            <div class="ForgotPassword">
                <a href="rescuePassword.php">Forgot password?</a>
            </div>
        </div>
    </div>
</main>
<footer id="footer">
    <script>
        $(function() {
            $("#footer").load("footer.html");
        });
    </script>
</footer>
<script src="../js/login.js"></script>
</body>
</html>