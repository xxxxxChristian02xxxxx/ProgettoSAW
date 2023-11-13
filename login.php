<!DOCTYPE html>
<html lang="en">
<?php
require('header.php');
?>

<body>
    <div class="PageLogin">
        <h2>Insert email and password and click Sign-in</h2>
    </div>
    <div class="LoginForm">
        <form id="UserRegistration" action="login.php" method="POST">

            <div class="Email">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email"><br>
            </div>
            <div class="Password">
                <label for="pass">Password:</label>
                <input type="password" id="pass" name="pass"><br>
            </div>
            <div class="RememberMe">
                <label for="ReMe">Remember Me:</label>
                <input type="checkbox" id="ReMe" name="ReMe"><br>
            </div>
            <div class="Submit">
                <input type="submit" value="Sign-in">
            </div>
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
        $remember = $_POST['ReMe'] ? 1 : 0;

        //Connessione al db
        require("connection.php");

        //Sanificazione input
        $email = $con->real_escape_string($email);
        $password = $con->real_escape_string($password);

        //Preparazione della query
        $query = "SELECT * FROM USERS WHERE EMAIL='$email'";

        //Esecuzione della query
        $res = $con->query($query);

        $row = $res->fetch_assoc();

        $storedPassword = $row["PASSWORD"];

        if(password_verify($password, $storedPassword)){
            $_SESSION['loggedIn'] = true;
            $_SESSION['id'] = $row["ID"];
            $_SESSION['firstname'] = $row["FIRSTNAME"];
            $_SESSION['lastname'] = $row["LASTNAME"];
            $_SESSION['email'] = $row["EMAIL"];
            $_SESSION['password'] = $row["PASSWORD"];
            $_SESSION['roles'] = $row["ROLES"];
            $_SESSION['banned'] = $row["BANNED"];
            $_SESSION['remember'] = $remember;
            if($remember){
                require("connection.php");

                $con->real_escape_string($remember);

                $query = "UPDATE USERS SET REMEMBER='$remember'";

                $con->query($query);

                require("RememberMe.php");
            }

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

