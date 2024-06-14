<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');
$session = getSession(true);

require("function_files/connection.php");
$con = connect();

$query = "SELECT SUBJECT, TYPE, DATE, TOTAL_TIME, TOTAL_REWARD, DESCRIPTION 
          FROM STUDY_SESSIONS
          INNER JOIN USERS ON STUDY_SESSIONS.USER = USERS.ID
          WHERE USERS.EMAIL = ?
          ORDER BY STUDY_SESSIONS.DATE";
$stmt = $con->prepare($query);
$stmt->bind_param('s', $session['email']);
$stmt->execute();

$data = array();

$result = $stmt->get_result();

header('Content-Type: application/json');
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        //to apply it to each element of the array
        $sanitized_row = array_map('htmlspecialchars', $row);
        $data[] = $sanitized_row;
    }
}

$con->close();

echo json_encode($data);
