<?php
session_start();
if(!function_exists('deleteUser')){
function deleteUser($email){
    require('connection.php');
    $con = connect();

    $query = "DELETE FROM USERS WHERE EMAIL=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $query = "SELECT * FROM USERS"; // query
    $stmt = $con->prepare($query); // execute query
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();

    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            $sanitized_row = array_map('htmlspecialchars', $row);
            $data[] = $sanitized_row;        }
    }

    $con->close();
    header('Content-Type: application/json');
    echo json_encode($data);
    }
}
$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    require('session.php');
    $session_variables = getSession(true);
    if($session_variables['role']) {
        if (isset($data['action']) && $data['action'] === 'deleteUser') {
            deleteUser($data['email']);
        } else {
            echo json_encode('Unsupported action');
        }
    }
    else{
        echo json_encode("You can't delete users, you're not an admin");
    }
}