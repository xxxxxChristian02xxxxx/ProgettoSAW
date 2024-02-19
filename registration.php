<?php
if ($_POST['submit'] == "submit") {
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

    include("backend/function_files/connection.php");
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

