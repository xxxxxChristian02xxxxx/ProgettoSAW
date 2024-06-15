<?php
session_start();
require("function_files/test_session.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');


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
    $stmt->bind_param('s', $search);
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

    include('function_files/session.php');

    // Loop through each item in the cart
    foreach($cart as $item) {
        // Here you would typically update the database to reflect the purchase
        // This is just a placeholder. Replace this with your actual database query
        purchaseItem($item, $_SESSION['id'], $con, $money);

    }
    $con->close();
    // Return a success message
    header('Content-Type: application/json');
    echo json_encode(['cart' => 'Purchase successful']);
}

function purchaseItem($item, $userId, $con, $money)
{
    //include('be_show_profile.php');
    if ($money>=$item[2]) {
        $query = "UPDATE USERS SET MONEY = MONEY - ? WHERE ID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ii', $item[2], $_SESSION['id']);
        $stmt->execute();

        for ($i = 0; $i < $item[1]; $i++) {
            $query = "INSERT INTO TRANSACTIONS(TRANSACTIONS_ID, USER_ID, PLANT_ID,DATE) VALUES (NULL,?, ?,NULL)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ii',$userId, $item[3]);
            //Esecuzione della query
            $stmt->execute();
        }
    }
}