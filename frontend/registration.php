<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign-up</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
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

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('UserRegistration').addEventListener('submit', function (event) {
                if (!validateInput()) {
                    event.preventDefault();

                    validateInput();

                    document.getElementById('UserRegistration').submit();
                }
            });
        });
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
    <div class="PageTitle">
        <h1>User Registration</h1>
    </div>
    <div class="RegistrationForm">
        <form id="UserRegistration" action="../backend/be_registration.php" method="POST">
            <table>
                <tr>
                    <td><label for="firstname">Firstname:</label></td>
                    <td>
                        <input type="text" id="firstname" name="firstname">
                        <span id="firstnameError" class="error"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="lastname">Lastname:</label></td>
                    <td>
                        <input type="text"  id="lastname" name="lastname">
                        <span id="lastnameError" class="error"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td>
                        <input type="email" id="email" name="email">
                        <span id="emailError" class="error"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="pass">Password:</label></td>
                    <td>
                        <input type="password" id="pass" name="pass">
                        <span id="passwordError" class="error"></span>
                    </td>
                </tr>
                <tr>
                    <td><label for="confirm">Confirm password:</label></td>
                    <td>
                        <input type="password" id="confirm" name="confirm">
                        <span id="confirmError" class="error"></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" value="Submit"></td>
                </tr>
            </table>
        </form>
    </div>

    <div id="errorMessages" class="error"></div>

    <script src="../js/emailVerify.js"></script>

    <footer>
        <p>Copyright © 2023. All rights reserved.</p>
    </footer>
</body>
</html>

