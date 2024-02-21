<?php
session_start();
// Get the raw POST data
if ($_POST['submit'] == 'submit') {
    $email = $_POST['email'];
    $email = trim($email);
    $password = $_POST['pass'];
    $password = trim($password);

    include('backend/be_login.php');
    $response = login($email, $password, false);
    echo json_encode($response);
}
