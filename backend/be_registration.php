<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    if ($con->affected_rows == 1) {
        //Utente registrtato correttamente, posso chiudere la connessione
        $con->close();

        //Rimando alla pagina di login a seguito della registrazione
        header("Location: login.php");
    } else {
        //Viene restituito un errore, non è stato possibile aggiungere utente al db
    }
}
//    }

