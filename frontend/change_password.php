<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit profile</title>
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
    <div class="PageUpdate">
        <div class="headerMyProfile">
            <h1>Edit Profile</h1>
        </div>
        <div class="UpdateForm">
            <form id="UserUpdate" action="be_changepassword.php" method="POST">
                <div class="LastPassword">
                    <label for="lastpass">Last Password:</label>
                    <input type="password" id="lastpass" name="lastpass"><br>
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
        <script src="../js/updatePassword.js">
        </script>

    </div>
</main>
<footer id="footer">
    <?php
    include('footer.html');
    ?>
</footer>
</body>
</html>