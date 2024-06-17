<?php
session_start();
require("function_files/test_session.php");
include("function_files/inputCheck.php");
require_once('function_files/connection.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    // Decode the JSON data
    $data = json_decode($input, true);

    if (isset($data['data']) && isset($data['action']) && $data['action'] === 'updateProfileData') {
        // Extract the passwords and email from the data array
        $lastPassword = trim($data['data']['lastPassword']);
        $newPassword = trim($data['data']['newPassword']);
        $confirm = trim($data['data']['confirm']);

        $con = connect();

        $query = "SELECT PASSWORD FROM USERS WHERE ID= ? ";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $_SESSION['id'] );
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows !== 1) {
            echo json_encode(['success' => false]);
        } else {
            $row = $res->fetch_assoc();
            $storedPassword = $row["PASSWORD"];

            if (password_verify($lastPassword, $storedPassword) && $newPassword === $confirm) {

                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                $updateSql = "UPDATE USERS SET PASSWORD = ? WHERE ID = ?";

                $updateStmt = $con->prepare($updateSql);
                $updateStmt->bind_param("ss", $newHashedPassword, $_SESSION['id']);

                if ($updateStmt->execute()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false]);
                }
            }else{
                echo json_encode(['success' => false]);
            }
        }
    }else{
        echo json_encode(['success' => false]);
    }
}

