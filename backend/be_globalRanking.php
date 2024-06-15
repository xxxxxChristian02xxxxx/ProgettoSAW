<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');

require("function_files/connection.php");
$con = connect();

$query = "SELECT CONCAT(USERS.FIRSTNAME, ' ', USERS.LASTNAME) AS USER, 
		  (SELECT MAX(PLANTS.PRICE) FROM PLANTS INNER JOIN TRANSACTIONS ON PLANTS.PLANTS_ID = TRANSACTIONS.PLANT_ID 
		   INNER JOIN STUDY_SESSIONS ON TRANSACTIONS.USER_ID = STUDY_SESSIONS.USER) AS MOST_EXPENSIVE_STICKER ,
          SUM(STUDY_SESSIONS.TOTAL_TIME) AS TOTAL_STUDY_TIME
          FROM USERS INNER JOIN STUDY_SESSIONS ON USERS.ID = STUDY_SESSIONS.USER 
          GROUP BY USERS.ID
          ORDER BY TOTAL_STUDY_TIME DESC";
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