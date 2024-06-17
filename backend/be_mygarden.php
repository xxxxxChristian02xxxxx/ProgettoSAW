 <?php
session_start();
require ("function_files/test_session.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("function_files/connection.php");
$con = connect();

$query = "SELECT PLANTS.PLANTS_ID, PLANTS.NAME, PLANTS.IMG_DIR, PLANTS.PRICE AS PLANT_AMOUNT, COUNT(TRANSACTIONS.PLANT_ID) AS COUNTERTIMES, SUM(PLANTS.PRICE) AS TOTAL_AMOUNT 
          FROM (PLANTS JOIN TRANSACTIONS ON TRANSACTIONS.PLANT_ID = PLANTS.PLANTS_ID)
          WHERE TRANSACTIONS.USER_ID = ?
          GROUP BY TRANSACTIONS.USER_ID, PLANTS.PLANTS_ID";
$stmt = $con->prepare($query); // execute query
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$result = $stmt->get_result();

$data = array();

header('Content-Type: application/json');
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $sanitized_row = array_map('htmlspecialchars', $row);
        $data[] = $sanitized_row;
    }
}

$con->close();

echo json_encode($data);