<?php
session_start();
require("function_files/test_session.php");
    function rethriveData()
    {
        require_once('function_files/connection.php');
        $con = connect();

        

        $query = "  SELECT ID, FIRSTNAME, LASTNAME, EMAIL, MONEY,
                    (SELECT COUNT(DISTINCT TRANSACTIONS_ID) FROM TRANSACTIONS WHERE USER_ID = ?) AS OCCURENCIESPLANT,
                    (SELECT SUM(TOTAL_TIME) FROM STUDY_SESSIONS WHERE STUDY_SESSIONS.USER = ?) AS TOTAL_TIME
                    FROM USERS
                    WHERE ID = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param('iii', $_SESSION['id'], $_SESSION['id'], $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        error_log('cio');
        if ($result->num_rows === 1) {
            $data = $result->fetch_assoc();
            $sanitized_data = array_map('htmlspecialchars', $data);

            $con->close();
            header('Content-Type: application/json');
            echo json_encode($sanitized_data);
            return $sanitized_data;
        }else{
            echo(['error' => 'Something went wrong with the query result']);
        }

}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'rethriveData':
                rethriveData();
                break;
        }
    }else{
        echo json_encode(['error' => 'Something went wrong with the query result']);
    }
}