<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');
$session = getSession(true);

include("function_files/connection.php");
$con = connect();

//creazione prepared statemet per prelevare tutta la tabella
$query = "SELECT ID, FIRSTNAME, LASTNAME, EMAIL, PASSWORD, ROLES, BANNED, MONEY FROM USERS"; // query
$stmt = $con->prepare($query); // execute query
$stmt->execute();
$result = $stmt->get_result();

$data = array();

header('Content-Type: application/json');
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
}

$con->close();

echo json_encode($data);

?>