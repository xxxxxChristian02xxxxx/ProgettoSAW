<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign-up</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../form.css">
    <script>
        function validateInput() {

            // Recupero dei valori inseriti in input
            const firstname = document.getElementById('firstname').value;
            const lastname = document.getElementById('lastname').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('pass').value;
            const confirm = document.getElementById('confirm').value;


            if (firstname === '') {
                document.getElementById('firstnameError').innerHTML = 'Il campo firstname è obbligatorio';
            } else {
                document.getElementById('firstnameError').innerHTML = '';
            }

            if (lastname === '') {
                document.getElementById('lastnameError').innerHTML = 'Il campo lastname è obbligatorio';
            } else {
                document.getElementById('lastnameError').innerHTML = '';
            }

            if (email === '') {
                document.getElementById('emailError').innerHTML = 'Il campo email è obbligatorio';
            } else {
                document.getElementById('emailError').innerHTML = '';
            }

            if (password !== '' && confirm !== '') {
                if (password !== confirm) {
                    alert('Passwords do not match');
                    return false;
                }
            } else {
                document.getElementById('confirmError').innerHTML = 'I campi password e confirm è obbligatori';
            }

            const errorMessage = document.querySelectorAll('.error');
            for (let i = 0; i < errorMessage.length; i++) {
                if (errorMessage[i].innerHTML !== '') {
                    return;
                }
            }
        }
        /*
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('UserRegistration').addEventListener('submit', function (event) {
                if (!validateInput()) {
                    event.preventDefault();

                    validateInput();

                    document.getElementById('UserRegistration').submit();
                }
            });
        });
         */
    </script>
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
        <form id="UserRegistration" action="" method="POST">
            <div class="Firstname">
                <label for="firstname">Firstname:</label>
                <input type="text" id="firstname" name="firstname">
                <span id="firstnameError" class="error"></span>
            </div>
            <div class="Lastname">
                <label for="lastname">Lastname:</label>
                <input type="text"  id="lastname" name="lastname">
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
                <input type="submit" value="Sign-up">
            </div>
        </form>
    </div>
    <div id="errorMessages" class="error"></div>
</div>
<script src="../js/emailVerify.js"></script>
<script src="../js/registration.js"></script>

<footer>
    <p>Copyright © 2023. All rights reserved.</p>
</footer>
</body>
</html>

