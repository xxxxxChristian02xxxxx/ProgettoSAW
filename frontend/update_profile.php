<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit profile</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/form.css">

    <script src="../js/emailVerify.js"></script>
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
            <form id="UserUpdate" action="update_profile.php" method="POST">
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

                <div id="Submit">
                    <input type="submit" value="Update">
                </div>

            </form>
        </div>

        <div class="headerMyProfile">
            <div id="ChangePassword">
                <h5>To change the password click here:</h5>
                <button id="changePassword">Change Password</button>
            </div>
        </div>
        <script src="../js/updateProfile.js"></script>

    </div>
    </main>
<footer id="footer">
    <?php
    include('footer.html');
    ?>
</footer>
</body>
</html>