<?php
session_start();
require ('../backend/function_files/inputCheck.php');

function addSessionStudied($moneyObtainedFromSession, $typesession, $total_time_spent, $subjectStudied, $descriptionSession){
    require('function_files/session.php');
    $session_variables = getSession(true);
    $userId =$session_variables['id'];

    require('function_files/connection.php');
    $con = connect();

    $query = "UPDATE USERS SET MONEY = MONEY + ? WHERE ID =?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ii', $moneyObtainedFromSession, $userId);
    $stmt->execute();
    if ($stmt->affected_rows !== 1) {
        echo "Error in user money modification";
    }

    $query = "INSERT INTO STUDY_SESSIONS (SESSION_ID, TYPE, DATE, TOTAL_TIME, TOTAL_REWARD, USER, SUBJECT, DESCRIPTION) VALUES (NULL, ?, CURRENT_DATE, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($query);
    $stmt->bind_param('iiiiss', $typesession, $total_time_spent, $moneyObtainedFromSession, $userId, $subjectStudied, $descriptionSession);
    $stmt->execute();

    // Recupero l'id della sessione - restituisce l'id autogenerato nell'esecuzione dell'ultima query
    $sessionId = mysqli_insert_id($con);
    error_log("sono qui: ". $sessionId);
    // Query per ricavare id della materia studiata
    $query = "SELECT ID FROM SUBJECTS WHERE NAME = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $subjectStudied);
    $stmt->execute();
    $res = $stmt->get_result();

    if($res->num_rows === 1){
        error_log("qui ci siamo");
        $row = $res->fetch_assoc();

        $subjectId = $row['ID'];
        error_log("sono qua: ". $subjectId);
        $query = "INSERT INTO subject_sessions (SUBJECT_ID, SESSION_ID) VALUES (?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ii", $subjectId, $sessionId);
        $stmt->execute();
        $con->close();
    }
    else{
        echo("Something went wrong with the query result");
    }
}

function updateSubject($subjectStudied){
    require('function_files/session.php');
    $session_variables = getSession(true);

    require('function_files/connection.php');
    $con = connect();

        $query = "INSERT INTO SUBJECTS (NAME) VALUES (?) ON DUPLICATE KEY UPDATE NAME=NAME";
        $stmt=$con->prepare($query);
        $stmt->bind_param('s',$subjectStudied);

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
    require('function_files/session.php');
    $session_variables = getSession(true);
    $userId =$session_variables['id'];
    require('function_files/connection.php');
    $con = connect();

        $query = "SELECT DISTINCT SUBJECT FROM STUDY_SESSIONS WHERE STUDY_SESSIONS.USER = ?";
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