<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');


require("function_files/connection.php");
$con = connect();

$query = "SELECT SUBJECT, SUM(STUDY_SESSIONS.TOTAL_TIME) AS TOTAL_TIME_STUDIED, SUM(STUDY_SESSIONS.TOTAL_REWARD) AS TOTAL_REWARD 
          FROM STUDY_SESSIONS 
          GROUP BY SUBJECT
          ORDER BY TOTAL_REWARD DESC";
$stmt = $con->prepare($query);
$stmt->execute();
$res = $stmt->get_result();

$data = array();

header('Content-Type: application/json');
if($res->num_rows > 0)
    while($row = $res->fetch_assoc()){
        $sanitized_row = array_map('htmlspecialchars', $row);
        $data[] = $sanitized_row;
    }

$con->close();

echo json_encode($data);