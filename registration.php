<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sign-up</title>

    <style>
        .error {
            color: red;
            display: block;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('UserRegistration').addEventListener('submit', function (event) {
                if (!validateInput()) {
                    event.preventDefault();
                }

                function validateInput() {

                    // Recupero dei valori inseriti in input
                    var firstname = document.getElementById('firstname').value;
                    var lastname = document.getElementById('lastname').value;
                    var email = document.getElementById('email').value;
                    var password = document.getElementById('pass').value;
                    var confirm = document.getElementById('confirm').value;


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


                    var errorMessage = document.querySelectorAll('.error');
                    for (var i = 0; i < errorMessage.length; i++) {
                        if (errorMessage[i].innerHTML !== '') {
                            return;
                        }
                    }

                    if (document.getElementById('errorMessages').innerHTML === '') {
                        document.getElementById('UserRegistration').submit();
                    }
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('email').addEventListener('change', function (event) {
                var emailInput = document.getElementById('email').value;

                fetch('emailVerify.php', {
                    method: 'POST',
                    headers: {
                        'Content-type': 'application/json',
                    },
                    body: JSON.stringify({email: emailInput}),
                })
                    .then(response => response.json())
                    .then(data => {
                        if(data) {
                            document.getElementById('emailError').innerHTML = 'Email already used, try a different one';
                        }
                        })
                        .catch(error => {
                            // Gestione degli errori durante la chiamata
                            console.error('Si è verificato un errore durante la fetch:', error);
                        })
            });
        });
    </script>
</head>

<body>
    <?php
        require("header.php");
    ?>
    <div class="PageTitle">
        <h1>User Registration</h1>
    </div>
    <div class="RegistrationForm">
        <form id="UserRegistration" action="registration.php" method="POST">
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

    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        //Memorizzazione in variabili dei dati inseriti nel form
        $firstname = $_POST['firstname'];
        $firstname = trim($firstname);
        $lastname = $_POST['lastname'];
        $lastname = trim($lastname);
        $email = $_POST['email'];
        $email = trim($email);
        $password = $_POST['pass'];
        $password = trim($password);
        $confirm = $_POST['confirm'];
        $confirm = trim($confirm);

        /*if($password != $confirm){
            echo "<h2>Passwords do not match</h2>";
        }
        else if(empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirm)){
            echo "<h2>Check input data, some are missing</h2>";
        }
        else{
*/
            include("function_files/connection.php");
            $con = connect();

            //Sanificazione dell'input
            $firstname = $con->real_escape_string($firstname);
            $lastname = $con->real_escape_string($lastname);
            $email = $con->real_escape_string($email);
            $password = $con->real_escape_string($password);

            //Cifratura della password
            $password = password_hash($password, PASSWORD_DEFAULT);

            //Preparazione della query per aggiungere un nuovo utente
            //Vediamo poi i prepared statement
            $query = "INSERT INTO USERS(FIRSTNAME, LASTNAME, EMAIL, PASSWORD) VALUES ('$firstname', '$lastname', '$email', '$password')";

            //Esecuzione della query
            $con->query($query);

            if($con->affected_rows == 1){
                //Utente registrtato correttamente, posso chiudere la connessione
                $con->close();

                //Rimando alla pagina di login a seguito della registrazione
                header("Location: login.php");
            }
            else{
                //Viene restituito un errore, non è stato possibile aggiungere utente al db
            }
        }
//    }

    ?>
    <footer>
        <p>Copyright © 2023. All rights reserved.</p>
    </footer>
</body>
</html>

