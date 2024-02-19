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
$query = "SELECT NAME, IMG_DIR, PRICE FROM PLANTS";
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
    $query = "SELECT NAME, IMG_DIR, PRICE FROM PLANTS WHERE NAME LIKE ?";
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

if(isset($_POST['buy'])){
    $cart = $_POST['cart'];
    $price = 0;
    foreach($cart as $item){
        for($i= 0; $i<$item; $i++){
            $price += $item[3];
        }
    }
    $risposta['price'] = $price;
    echo json_encode($risposta);
}