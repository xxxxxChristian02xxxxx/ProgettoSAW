<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get the raw POST data
$postData = file_get_contents("php://input");

// Decode the JSON data
$data = json_decode($postData, true);
error_log(print_r($data, true));
if ($data && $_SERVER["REQUEST_METHOD"] == "POST") {
    //Memorizzazione in variabili dei dati inseriti nel form
    $firstname = $data['firstname'];
    $firstname = trim($firstname);
    $lastname = $data['lastname'];
    $lastname = trim($lastname);
    $email = $data['email'];
    $email = trim($email);
    $password = $data['pass'];
    $password = trim($password);
    $confirm = $data['confirm'];
    $confirm = trim($confirm);

    include("function_files/connection.php");
    $con = connect();

    //Cifratura della password
    $password = password_hash($password, PASSWORD_DEFAULT);

    //Preparazione della query per aggiungere un nuovo utente
    //Vediamo poi i prepared statement
    $query = "INSERT INTO USERS(ID, FIRSTNAME, LASTNAME, EMAIL, PASSWORD) VALUES (NULL, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssss', $firstname, $lastname, $email, $password);
    //Esecuzione della query
    $stmt->execute();

    if ($stmt->affected_rows == 1) {
        //Utente registrtato correttamente, posso chiudere la connessione
        http_response_code(200);
        $data = array("success" => true);
    } else {
        //Non è stato possibile aggiungere utente al db
        $data = array("success" => false);
    }
    $con->close();
    error_log(print_r($data, true));
    echo json_encode($data);
}

