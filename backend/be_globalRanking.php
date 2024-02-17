<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');
$session = getSession(true);

require("function_files/connection.php");
$con = connect();

$query = "SELECT CONCAT(USERS.FIRSTNAME, ' ', USERS.LASTNAME) AS USER, 
          PLANTS.PRICE AS MOST_EXPENSIVE_STICKER, 
          SUM(STUDY_SESSIONS.TOTAL_TIME) AS TOTAL_STUDY_HOURS
          FROM PLANTS INNER JOIN TRANSACTIONS ON PLANTS.PLANTS_ID = TRANSACTIONS.PLANT_ID
          INNER JOIN USERS ON TRANSACTIONS.USER_ID = USERS.ID
          INNER JOIN STUDY_SESSIONS ON USERS.ID = STUDY_SESSIONS.USER 
          GROUP BY USERS.ID 
          ORDER BY TOTAL_STUDY_HOURS DESC";
$stmt = $con->prepare($query);
$stmt->execute();
$res = $stmt->get_result();

$data = array();

header('Content-Type: application/json');
if($res->num_rows > 0)
    while($row = $res->fetch_assoc()){
        $data[] = $row;
    }
error_log(print_r($data, true));
$con->close();

echo json_encode($data);