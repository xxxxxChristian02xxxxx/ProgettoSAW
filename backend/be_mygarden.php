<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');
$session = getSession(true);

include("function_files/connection.php");
$con = connect();
$userid =$session['id'];


$query = "SELECT plants.PLANTS_ID, plants.NAME, plants.IMG_DIR, plants.PRICE AS PLANT_AMOUNT, COUNT(transactions.PLANT_ID) AS COUNTERTIMES, SUM(plants.PRICE) AS TOTAL_AMOUNT 
          FROM (plants JOIN transactions ON transactions.PLANT_ID = plants.PLANTS_ID) JOIN users ON users.ID=transactions.USER_ID 
          WHERE users.ID= ?
          GROUP BY transactions.USER_ID, plants.PLANTS_ID;";
$stmt = $con->prepare($query); // execute query
$stmt->bind_param('i', $userid);
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