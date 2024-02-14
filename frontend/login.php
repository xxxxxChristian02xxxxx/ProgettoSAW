<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
</head>

<body>
<div id="header">
    <script>
        $(function () {
            $("#header").load("public_header.html");
        });
    </script>
</div>

<div class="PageLogin">
    <h2>Insert email and password and click Sign-in</h2>
</div>
<div class="LoginForm">
    <form id="UserRegistration" action="login.php" method="POST">
        <table>
            <div class="Email">
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" id="email" name="email"></td>
                </tr>
            </div>
            <div class="Password">
                <tr>
                    <td><label for="pass">Password:</label></td>
                    <td><input type="password" id="pass" name="pass"></td>
                </tr>
            </div>
            <div class="RememberMe">
                <tr>
                    <td>
                        <a href="rescuePassword.php">I forgot my password</a>
                    </td>
                </tr>
            </div>
            <div class="RememberMe">
                <tr>
                    <td><label for="ReMe">Remember Me:</label></td>
                    <td><input type="checkbox" id="ReMe" name="ReMe"></td>
                </tr>
            </div>
            <div id="Submit">
                <tr>
                    <td colspan="2"><input type="submit" value="Sign-in"></td>
                </tr>
            </div>
        </table>
    </form>
</div>
<script src="../js/login.js"></script>

<footer>
    <p>Copyright © 2023. All rights reserved.</p>
</footer>
</body>
</html>

