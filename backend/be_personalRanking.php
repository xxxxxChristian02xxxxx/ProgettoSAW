<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');
$session = getSession(true);

require("function_files/connection.php");
$con = connect();

$query = "SELECT SUBJECTS.NAME AS SUBJECT, SUM(STUDY_SESSIONS.TOTAL_TIME) AS TOTAL_TIME_STUDIED, SUM(STUDY_SESSIONS.TOTAL_REWARD) AS TOTAL_REWARD 
          FROM STUDY_SESSIONS INNER JOIN SUBJECT_SESSIONS ON STUDY_SESSIONS.SESSION_ID = SUBJECT_SESSIONS.SESSION_ID 
          INNER JOIN SUBJECTS ON SUBJECT_SESSIONS.SUBJECT_ID = SUBJECTS.ID 
          GROUP BY SUBJECTS.NAME 
          ORDER BY TOTAL_REWARD DESC";
$stmt = $con->prepare($query);
$stmt->execute();
$res = $stmt->get_result();

$data = array();

header('Content-Type: application/json');
if($res->num_rows > 0)
    while($row = $res->fetch_assoc()){
        $data[] = $row;
    }

$con->close();

echo json_encode($data);