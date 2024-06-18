<?php
session_start();
require("function_files/test_session.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);


include("function_files/connection.php");
$con = connect();

if(isset($_GET['flowers'])){
$query = "SELECT PLANTS_ID, NAME, IMG_DIR, PRICE FROM PLANTS";
    $stmt = $con->prepare($query);
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
}

if(isset($_GET['search'])){
    $search = $_GET['search'];
    $query = "SELECT PLANTS_ID, NAME, IMG_DIR, PRICE FROM PLANTS WHERE NAME LIKE ?";
    $stmt = $con->prepare($query);
    $str = '%' . $search . '%';
    $stmt->bind_param('s', $str);
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
}



if(isset($_GET['buy'])){
    $data = json_decode(file_get_contents('php://input'), true);
    $cart = $data['carts'];
    $money = $data['money'];

    foreach($cart as $item) {
        purchaseItem($item, $con, $money);
    }
    $con->close();
    header('Content-Type: application/json');
    echo json_encode(['cart' => 'Purchase successful']);
}

function purchaseItem($item, $con, $money)
{
    // item(name, quantity, price, plant_id)
    if ($money>=$item[2]) {
        $query = "UPDATE USERS SET MONEY = MONEY - ? WHERE ID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ii', $item[2], $_SESSION['id']);
        $stmt->execute();

        for ($i = 0; $i < $item[1]; $i++) {
            $query = "INSERT INTO TRANSACTIONS(USER_ID, PLANT_ID) VALUES (?, ?)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ii',$_SESSION['id'], $item[3]);
            //Esecuzione della query
            $stmt->execute();
        }
    }
}