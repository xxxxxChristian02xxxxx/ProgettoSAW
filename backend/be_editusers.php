<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');
$session = getSession(true);

include("function_files/connection.php");
$con = connect();

//creazione prepared statemet per prelevare i dati dalla la tabella
$query = "SELECT ID, FIRSTNAME, LASTNAME, EMAIL, ROLES, BANNED, MONEY FROM USERS"; // query
$stmt = $con->prepare($query); // execute query
$stmt->execute();
$result = $stmt->get_result();

$data = array();

header('Content-Type: application/json');
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $sanitized_row = array_map('htmlspecialchars', $row);
        error_log(print_r($sanitized_row, true));
        $data[] = $sanitized_row;
    }
}

$con->close();
error_log(print_r($data, true));
echo json_encode($data);