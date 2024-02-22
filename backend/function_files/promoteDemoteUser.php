<?php
session_start();
if(!function_exists('promoteDemote')) {
    function promoteDemote($email)
    {
        require('connection.php');
        $con = connect();

        $query = "UPDATE USERS SET ROLES = !ROLES WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        if($stmt->affected_rows === 1){
            $query = "SELECT ROLES FROM USERS WHERE EMAIL = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            $data = $result->fetch_assoc();
            $sanitized_data =htmlspecialchars($data);

            $con->close();

            header('Content-Type: application/json');
            echo json_encode($sanitized_data);
        }
        else{
            echo('Something went wrong with the query result');
        }
    }
}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    require('session.php');
    $session_variables = getSession(true);
    if($session_variables['role']) {
        if (isset($data['action']) && $data['action'] === 'promoteDemote') {
            promoteDemote($data['email']);
        } else {
            echo json_encode('Unsupported action');
        }
    }
    else{
        echo json_encode("You can't promote or demote users, you're not an admin");
    }
}