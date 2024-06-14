<?php
session_start();

include('function_files/session.php');
$session = getSession(true);

include("function_files/connection.php");
$con = connect();

$query = "SELECT ID, FIRSTNAME, LASTNAME, EMAIL, ROLES, BANNED, MONEY FROM USERS";
$stmt = $con->prepare($query);
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

echo json_encode($data);