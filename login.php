<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
</head>
<?php
require('header.php');
?>

<body>
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
                        <td><label for="ReMe">Remember Me:</label></td>
                        <td><input type="checkbox" id="ReMe" name="ReMe"></td>
                    </tr>
                </div>
                <div class="Submit">
                    <tr>
                        <td colspan="2"><input type="submit" value="Sign-in"></td>
                    </tr>
                </div>
            </table>
        </form>
    </div>
    <?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $email = trim($email);
        $password = $_POST['pass'];
        $password = trim($password);
        if(isset($_POST['ReMe'])) {
            $remember = true;
        }
        else{
            $remember = false;
        }

        //Connessione al db
        include("function_files/connection.php");
        $con = connect();

        //Sanificazione input
        $email = $con->real_escape_string($email);
        $password = $con->real_escape_string($password);

        //Preparazione della
        //todo: trasform to prepared stmt brutto
        $query = "SELECT * FROM USERS WHERE EMAIL='$email'";
        $res = $con->query($query);
        $row = $res->fetch_assoc();

        $storedPassword = $row["PASSWORD"];
        echo $storedPassword;
        if(password_verify($password, $storedPassword)) {
            require('function_files/session.php');
            setSession($row['ID']);

            require("function_files/RememberMe.php");
            setRememberMe($remember);

            header("Location: main.php");
            exit();
        }

    }
    ?>

    <footer>
        <p>Copyright © 2023. All rights reserved.</p>
    </footer>
</body>
</html>

