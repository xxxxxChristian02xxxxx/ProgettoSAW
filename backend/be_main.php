<?php
session_start();
require ('../backend/function_files/inputCheck.php');

function addSessionStudied($moneyObtainedFromSession, $typesession, $total_time_spent, $subjectStudied, $descriptionSession){
    require('function_files/session.php');
    $session_variables = getSession(true);
    $userId =$session_variables['id'];

    require('function_files/connection.php');
    $con = connect();

    //---------------QUERY PER MODIFICARE I DATI DELL' UTENTE ---------------//
    $query = "UPDATE users SET MONEY = MONEY + ? WHERE ID =?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ii', $moneyObtainedFromSession, $userId);
    $stmt->execute();
    if ($stmt->affected_rows !== 1) {
        echo "Error in user money modification";
    }

    // DEVO CAMBIARE TOTAL REWARD, MA è PER VEDERE SE FUNZIONA
    $query = "INSERT INTO STUDY_SESSIONS (SESSION_ID, TYPE, DATE, TOTAL_TIME, TOTAL_REWARD, USER, SEASON, DESCRIPTION) VALUES (NULL, ?, CURRENT_TIMESTAMP, ?, ?, ?, NULL, ?)";

    $stmt = $con->prepare($query);
    $stmt->bind_param('iiiis', $typesession, $total_time_spent, $moneyObtainedFromSession, $userId, $descriptionSession);
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

    //---------------QUERY PER AGGIORNARE LA MATERIA STUDIATA SE NUOVA  ---------------//
    // Se duplicato, anzichè generare errore si aggiorna la riga andando a essegnare di fatto nuovamente lo stesso valore
    $query = "INSERT INTO subjects (NAME) VALUES (?) ON DUPLICATE KEY UPDATE NAME=NAME";
    $stmt=$con->prepare($query);
    $stmt->bind_param('s',$subjectStudied);
    //Esecuzione della query
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

    //---------------QUERY PER OTTENERE TUTTE LE MATERIE DI UNA PERSONA PER IL MENU A TENDINA ---------------//
    $query = "SELECT DISTINCT NAME FROM subjects 
              INNER JOIN subject_sessions ON SUBJECTS.ID = subject_sessions.SUBJECT_ID 
              INNER JOIN study_sessions ON subject_sessions.SESSION_ID = study_sessions.SESSION_ID
              WHERE study_sessions.USER =?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i',$userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $subjects = array();
    if($result->num_rows>0)
    {
        while($row = $result->fetch_assoc()) {
            $sanitized_row = array_map('htmlspecialchars', $row);
            $subjects = $sanitized_row;
        }
    }

    $con->close();

    header('Content-Type: application/json');
    echo json_encode($subjects);

}

$data = json_decode(file_get_contents('php://input'), true);

if($data && $_SERVER["REQUEST_METHOD"] === "POST") {

    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'addSessionStudied':
                if(!inputSubject($data['json_data']['subjectName'])){
                    echo json_encode('Sunbject not allowed');
                }
                addSessionStudied($data['json_data']['money'],$data['json_data']['typeSession'],$data['json_data']['timeSpent'], $data['json_data']['subjectName'],$data['json_data']['description']);
                break;
            case 'updateSubject':
                if(!inputSubject($data['json_data']['subjectName'])){
                    echo json_encode('Sunbject not allowed');

                }
                updateSubject($data['json_data']['subjectName']);
                break;
            case 'subjectTend':
                subjectTend();
                break;
        }
    }
    else{
        echo json_encode('azione non supportata');
    }
}