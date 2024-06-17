<?php
session_start();
require("function_files/test_session.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);


require("function_files/connection.php");
$con = connect();

$query = "SELECT  SUBJECT, TYPE, DATE, TOTAL_TIME, TOTAL_REWARD,  DESCRIPTION
          FROM STUDY_SESSIONS
          WHERE USER = ?
          ORDER BY STUDY_SESSIONS.DATE";
$stmt = $con->prepare($query);
$stmt->bind_param('s', $_SESSION['id']);
$stmt->execute();

$data = array();

$result = $stmt->get_result();

header('Content-Type: application/json');
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $sanitized_row = array_map('htmlspecialchars', $row);
        $data[] = $sanitized_row;
    }
}

$con->close();

echo json_encode($data);
