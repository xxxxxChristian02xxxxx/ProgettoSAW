<!DOCTYPE html>
<html lang="en">
<head>
    <title>Rescue Password</title>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link href="../css/form.css" rel="stylesheet" type="text/css">
    <link href="../css/rescuePassword.css" rel="stylesheet" type="text/css">
</head>

<body>
<header>
    <div id="header">
        <script>
            $(function() {
                $("#header").load("public_header.html");
            });
        </script>
    </div>
</header>
<main class="wrapper">

    <div class="rescuePassword">
        <div class="headerRescuePassword">
            <h1>Rescue password</h1>
        </div>
        <div class="rescuePasswordForm">
            <form id="UserRescuePassword" action="rescuePassword.php" method="POST">
                <div class="Email">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                    <span id="emailErro" class="errore">error</span><br>
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
                    <input id="update" type="submit" value="Update">
                </div>
            </form>
        </div>
        <div id="popUp" class="hidden">
            <div id="popUpContent">
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
<script src="../js/rescuePassword.js"></script>
</body>
</html>