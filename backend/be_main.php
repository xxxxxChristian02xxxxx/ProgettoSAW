<?php
session_start();
require ("function_files/test_session.php");
require ('../backend/function_files/inputCheck.php');
require_once('function_files/connection.php');

function addSessionStudied($moneyObtainedFromSession, $typesession, $total_time_spent, $subjectStudied, $descriptionSession)
{

    $userId = $_SESSION['id'];

    $con = connect();

    $query = "UPDATE USERS SET MONEY = MONEY + ? WHERE ID =?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ii', $moneyObtainedFromSession, $userId);
    $stmt->execute();
    if ($stmt->affected_rows !== 1) {
        echo "Error in user money modification";
    }

    $query = "INSERT INTO STUDY_SESSIONS ( TYPE, DATE, TOTAL_TIME, TOTAL_REWARD, USER, SUBJECT, DESCRIPTION) VALUES ( ?, CURRENT_DATE, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('iiiiss', $typesession, $total_time_spent, $moneyObtainedFromSession, $userId, $subjectStudied, $descriptionSession);
    $stmt->execute();

}

function updateSubject($subjectStudied){

    $con = connect();

        $query = "INSERT INTO SUBJECTS (NAME, CREATED_BY) VALUES (?, ?) ON DUPLICATE KEY UPDATE NAME=NAME";
        $stmt=$con->prepare($query);
        $stmt->bind_param('si',$subjectStudied, $_SESSION['id']);

        $stmt->execute();

    if ($stmt->affected_rows == 1) {
        header('Content-Type: application/json');

        echo json_encode("Subject correctly added or already existing") ;
    } else {
        header('Content-Type: application/json');

        echo json_encode("Error in adding new subject")  ;
    }
    $con->close();
}

function subjectTend(){
    
    $userId =$_SESSION['id'];

    $con = connect();

        $query = "SELECT DISTINCT NAME FROM SUBJECTS WHERE CREATED_BY = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i',$userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $subjects = array();

        if($result->num_rows>0)
        {
            while($row = $result->fetch_assoc()) {
                $sanitized_row = array_map('htmlspecialchars', $row);
                $subjects[] = $sanitized_row;
            }
        }

    $con->close();

    header('Content-Type: application/json');
    echo json_encode($subjects);

}

$data = json_decode(file_get_contents('php://input'), true);

if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'addSessionStudied':
                if (!inputSubject($data['json_data']['subjectName'])) {
                    echo json_encode('Sunbject not allowed');
                }
                addSessionStudied($data['json_data']['money'], $data['json_data']['typeSession'], $data['json_data']['timeSpent'], $data['json_data']['subjectName'], $data['json_data']['description']);
                break;
            case 'updateSubject':
                if (!inputSubject($data['json_data']['subjectName'])) {
                    echo json_encode('Sunbject not allowed');

                }
                updateSubject($data['json_data']['subjectName']);
                break;
            case 'subjectTend':
                subjectTend();
                break;
        }
    } else {
        echo json_encode('Unsupported action');
    }
}