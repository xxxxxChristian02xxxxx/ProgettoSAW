<?php
session_start();
if(!function_exists('addSessionStudied')){
    function addSessionStudied($moneyObtainedFromSession, $typesession, $total_time_spent, $subjectStudied, $seasonId, $descriptionSession){
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
        $query = "INSERT INTO STUDY_SESSIONS (SESSION_ID, TYPE, DATE, TOTAL_TIME, TOTAL_REWARD, USER, SEASON, DESCRIPTION) VALUES (NULL, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?, ?)";

        $stmt = $con->prepare($query);
        $stmt->bind_param('iiiiis', $typesession, $total_time_spent, $moneyObtainedFromSession, $userId, $seasonId, $descriptionSession);
        $stmt->execute();

        // Recupero l'id della sessione - restituisce l'id autogenerato nell'esecuzione dell'ultima query
        $sessionId = mysqli_insert_id($con);

        // Query per ricavare id della materia studiata
        $query = "SELECT ID FROM subjects WHERE NAME = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $subjectStudied);
        $stmt->execute();

        if($stmt->num_rows === 1){
            $res = $stmt->get_result();
            $row = $res->fetch_assoc();

            $subjectId = $row['ID'];

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
}
if(!function_exists('updateSubject')){
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
                addSessionStudied($data['json_data']['money'],$data['json_data']['typeSession'],$data['json_data']['timeSpent'], $data['json_data']['subjectName'], $data['json_data']['season'], $data['json_data']['description']);
                break;
            case 'updateSubject':
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