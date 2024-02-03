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
<script>
    document.getElementById('UserRegistration').addEventListener('submit', function (event) {

        event.preventDefault();

        const formData = {
            email: document.getElementById('email').value,
            pass: document.getElementById('pass').value,
            ReMe: document.getElementById('ReMe').checked
        };

        //chimata dal frontend login in backend login
        fetch('../backend/be_login.php', { // dico il percorso del file di back end
            method: 'POST', //metodo get o post
            headers: {
                'Content-Type': 'application/json' // specifico la uso
            },
            body: JSON.stringify(formData) // encode
        })
            .then(response => response.json()) //prendo la risposta di login backend(ha ottenuto i risultati delle query ) e li ha messi nella variabile
            .then(data => { //prendo i dati ottenuti e li processo

                if (data.success) {
                    window.location.href = 'main.php'; // se chiamata è andata bene faccio display del main.php
                } else {
                    window.alert('login failed'); //altimenti mando messaggio di errore
                }
            })
            .catch(error => {

                console.error('Error:', error);
            });
    });
</script>

<footer>
    <p>Copyright © 2023. All rights reserved.</p>
</footer>
</body>
</html>

