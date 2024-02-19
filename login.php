<?php
session_start();
// Get the raw POST data
if ($_POST['submit'] == 'submit') {
    $email = $_POST['email'];
    $email = trim($email);
    $password = $_POST['pass'];
    $password = trim($password);

    //Connessione al db
    include('backend/function_files/connection.php');
    $con = connect();

    //Preparazione della query con prepared statement
    $query = "SELECT * FROM USERS WHERE EMAIL= ? ";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $res = $stmt->get_result();

    header('Content-Type: application/json');
    if($res->num_rows !== 1){
        $response = array("success" => false);
    }
    else{
        $row = $res->fetch_assoc();
        if($row['BANNED']){
            $response = array("success" => false, "banned" => true);
        }
        else{
            $storedPassword = $row["PASSWORD"];

            if (password_verify($password, $storedPassword)) {
                require('backend/function_files/session.php');
                setSession($row['ID']);
                http_response_code(200);
                $response = array("success" => true, "banned" => false);
            }else{
                $response = array("success" => false, "banned" => false);
            }
        }
    }
    $con->close();
    echo json_encode($response);
}
