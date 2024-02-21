<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');
$session = getSession(true);

include("function_files/connection.php");
$con = connect();
$userid =$session['id'];

if(isset($_GET['flowers'])){
$query = "SELECT PLANTS_ID, NAME, IMG_DIR, PRICE FROM PLANTS";
    $stmt = $con->prepare($query);
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
            $data[] = $row;
        }
    }

    $con->close();

    echo json_encode($data);
}



if(isset($_GET['buy'])){
    $data = json_decode(file_get_contents('php://input'), true);
    $cart = $data['carts'];

    include('function_files/session.php');
    $session = getSession(true);

    include("function_files/connection.php");
    $con = connect();
    $userid =$session['id'];
    // Loop through each item in the cart
    include('show_profile.php');
    $data= rethriveData();
    $price = 0;
    foreach ($cart as $item) {
        $price += $item[2];
    }
    if ($data['MONEY']<$price) {
        echo json_encode(['cart' => 'Not enough money']);
        return;
    }
    foreach($cart as $item) {
        // Here you would typically update the database to reflect the purchase
        // This is just a placeholder. Replace this with your actual database query
        purchaseItem($item, $userid, $con);
    }
    $con->close();
    // Return a success message
    echo json_encode(['cart' => 'Purchase successful']);
}



function purchaseItem($item, $userid, $con)
{
        $query = "UPDATE USERS SET MONEY = MONEY - ? WHERE ID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ii', $item[2], $userid);
        $stmt->execute();
        if($stmt->affected_rows === 0){
            echo json_encode(['error' => 'Something went wrong with the query result']);
        }

        for ($i = 0; $i < $item[1]; $i++) {
            $query = "INSERT INTO TRANSACTIONS(TRANSACTIONS_ID, USER_ID, PLANT_ID,DATE) VALUES (NULL,?, ?,NULL)";
            $stmt = $con->prepare($query);
            $stmt->bind_param('ii', $userid, $item[3]);
            //Esecuzione della query
            $stmt->execute();
            if($stmt->affected_rows === 0){
                echo json_encode(['error' => 'Something went wrong with the query result']);
            }
        }

}