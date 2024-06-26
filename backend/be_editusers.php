<?php
session_start();
require ("function_files/test_session.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("function_files/connection.php");

if($_SESSION['loggedIn'] && $_SESSION['role']) {

    $con = connect();

    $query = "SELECT ID, FIRSTNAME, LASTNAME, EMAIL, ROLES, BANNED, MONEY FROM USERS"; // query
    $stmt = $con->prepare($query); // execute query
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();

    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sanitized_row = array_map('htmlspecialchars', $row);
            $data[] = $sanitized_row;
        }
    }

    $con->close();
    echo json_encode($data);
}