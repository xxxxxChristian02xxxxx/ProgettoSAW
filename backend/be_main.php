<?php
session_start();
if(!function_exists('addSessionStudied')){
    function addSessionStudied($moneyObtainedFromSession,$typesession,$total_time_spent, $seasonId, $descriptionSession){
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
            echo "error nella modifica dei soldi dell'utente ";
        }

        $query = "INSERT INTO study_sessions (SESSION_ID, TYPE, DATE, TOTAL_TIME, TOTAL_REWARD, USER, SEASON, DESCRIPTION) VALUES (NULL, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param('iiiiis', $typesession, $total_time_spent, $total_reward_obtained, $userId, $seasonId, $descriptionSession);
        $stmt->execute();

        // Recupero l'id della sessione
        $sessionId = mysqli_insert_id($con);

        // Query per ricavare id della materia studiata
        $query = "SELECT ID FROM subjects WHERE NAME = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $subjectStudied);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        $subjectId = $row['ID'];

        $query = "INSERT INTO subject_sessions (SUBJECT_ID, SESSION_ID) VALUES (?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ii", $subjectId, $sessionId);
        $stmt->execute();
        $con->close();
    }
}
if(!function_exists('updateSubject')){
    function updateSubject($subjectStudied){
        require('function_files/session.php');
        $session_variables = getSession(true);

        require('function_files/connection.php');
        $con = connect();

        //---------------QUERY PER AGGIORNARE LA MATERIA STUDIATA SE NUOVA  ---------------//
        $query = "INSERT INTO subjects (NAME) VALUES (?) ON DUPLICATE KEY UPDATE NAME=NAME";
        $stmt=$con->prepare($query);
        $stmt->bind_param('s',$subjectStudied);
        //Esecuzione della query
        if(!$stmt->execute()){
            header('Content-Type: application/json');

            echo json_encode("errore") ;


        }
        if ($stmt->affected_rows == 1) {
            header('Content-Type: application/json');

            echo json_encode("materia studiata aggiunta o già esistente") ;
        } else {
            header('Content-Type: application/json');

            echo json_encode("error per aggiungere la materia studiata")  ;
        }
        $con->close();

        header('Content-Type: application/json');
        echo json_encode("finito la queri");
    }
}
if(!function_exists('subjectTend')){
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
                $subjects[] = $row['NAME'];
            }
        }

        $con->close();

        header('Content-Type: application/json');
        echo json_encode($subjects);

    }
}
$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'addSessionStudied':
                addSessionStudied($data['money'],$data['typeSession'],$data['timeSpent'],$data['season'], $data['description']);
                break;
            case 'updateSubject':
                updateSubject($data['subjectName']);
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