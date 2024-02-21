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

    include('backend/be_registration.php');

    echo json_encode(registration($firstname, $lastname, $email, $password, $confirm));
}

