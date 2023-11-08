<html>
    <head></head>
    <body>
    <?php
        //Verifica che la sessione sia attiva
        require("session.php");

        //Aggiunta dell'header
        require("header.php");

        //Estrazione dei valori dalle variabili di sessione
        $s_firstname = $_SESSION['firstname'];
        $s_lastname = $_SESSION['lastname'];
        $s_email = $_SESSION['email'];
        $s_password = $_SESSION['password'];
    ?>

    //Form per aggiornare i dati
    <div class="UpdateForm">
        <form id="UserUpdate" action="myprofile.php" method="POST">
            <label for="firstname">Firstname:</label>
            <input type="text" id="firstname" name="firstname" value="$firstname"><br>

            <label for="lastname">Lastname:</label>
            <input type="text"  id="lastname" name="lastname" value="$lastname"><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="$email"><br>

            <label for="pass">New password:</label>
            <input type="password" id="pass" name="pass"><br>

            <label for="confirm">Confirm new password:</label>
            <input type="password" id="confirm" name="confirm"><br>

            <input type="submit" value="Update">
        </form>
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

                require("connection.php");
                //Sanificazione dell'input
                $con->mysqli_real_escape_string($firstname);
                $con->mysqli_real_escape_string($lastname);
                $con->mysqli_real_escape_string($email);
                if(!empty($_POST['pass'])) {
                    $con->mysqli_real_escape_string($password);

                    //Cifratura della password
                    $password = password_hash($password, PASSWORD_DEFAULT);
                }

                //Se è stato aggiornato il nome
                if($firstname != $s_firstname){
                    $query = "UPDATE USERS SET FIRSTNAME = '$firstname' WHERE EMAIL='$s_email'";
                    $con->query($query);
                }

                //Se è stato aggiornato il cognome
                if($lastname != $s_lastname){
                    $query = "UPDATE USERS SET LASTNAME = '$lastname' WHERE EMAIL='$s_email'";
                    $con->query($query);
                }

                //Se è stata aggiornata l'email
                if($email != $s_email){
                    $query = "UPDATE USERS SET EMAIL = '$email' WHERE EMAIL='$s_email'";
                    $con->query($query);
                }

                //Se è stata aggiornata la password
                if(!empty($_POST['pass']) && $password != $s_password){
                    if($password != $confirm){
                        echo "<h2>Passwords do not match</h2>";
                    }
                    else {
                        $query = "UPDATE USERS SET PASSWORD = '$password' WHERE EMAIL='$s_email'";
                        $con->query($query);
                    }
                }

                $con->close();
            }
        ?>
    </body>
</html>