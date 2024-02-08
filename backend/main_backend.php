<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require("function_files/session.php");
$session = getSession(true);

$json_data = file_get_contents('php://input');
$time_studying = json_decode($json_data, true);

// Scrivi il messaggio nel file (sovrascrivendo eventuali contenuti precedenti)


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Memorizzazione in variabili dei dati inseriti nel form
    $userId =$session['id'];
    $moneyObtainedFromSession=$time_studying['money'];
    $subjectStudied =$time_studying['subjectName'];
    $typesession =$time_studying['typeSession'];
    $total_time_spent=$time_studying['timeSpent'];
    $total_reward_obtained=$time_studying['money'];
    $seasonId = $time_studying['season'];
    $descriptionSession=$time_studying['description'];
    $typeoperation = $time_studying['operationType'];

    include("function_files/connection.php");
    $con = connect();

   if($typeoperation === 1) {
       //---------------QUERY PER MODIFICARE I DATI DELL' UTENTE ---------------//
       $query = "UPDATE USERS SET MONEY = MONEY + ? WHERE ID =?";
       $stmt = $con->prepare($query);
       $stmt->bind_param('ii', $moneyObtainedFromSession, $userId);
       $stmt->execute();
       if ($stmt->affected_rows !== 1) {
           echo "error nella modifica dei soldi dell'utente ";
       }

       $query = "INSERT INTO STUDY_SESSIONS (SESSION_ID, TYPE, DATE, TOTAL_TIME, TOTAL_REWARD, USER, SEASON, DESCRIPTION) VALUES (NULL, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?, ?)";
       $stmt = $con->prepare($query);
       $stmt->bind_param('iiiiis', $typesession, $total_time_spent, $total_reward_obtained, $userId, $seasonId, $descriptionSession);
       $stmt->execute();

       // Recupero l'id della sessione
       $sessionId = mysqli_insert_id($con);

       // Query per ricavare id della materia studiata
       $query = "SELECT ID FROM SUBJECTS WHERE NAME = ?";
       $stmt = $con->prepare($query);
       $stmt->bind_param("s", $subjectStudied);
       $stmt->execute();
       $res = $stmt->get_result();
       $row = $res->fetch_assoc();
       $subjectId = $row['ID'];

       $query = "INSERT INTO SUBJECT_SESSIONS (SUBJECT_ID, SESSION_ID) VALUES (?, ?)";
       $stmt = $con->prepare($query);
       $stmt->bind_param("ii", $subjectId, $sessionId);
       $stmt->execute();
       $con->close();
   }else if ($typeoperation === 2){
       //---------------QUERY PER AGGIORNARE LA MATERIA STUDIATA SE NUOVA  ---------------//
       $query = "INSERT INTO SUBJECTS (NAME) VALUES (?) ON DUPLICATE KEY UPDATE NAME=NAME";
       $stmt=$con->prepare($query);
       $stmt->bind_param('s',$subjectStudied);
       //Esecuzione della query
       $stmt->execute();
       if ($stmt->affected_rows == 1) {
           $mat = "materia studiata aggiunta o già esistente";
       } else {
           $mat = "error per aggiungere la materia studiata";
       }
       $con->close();
   }
    else if($typeoperation === 3){
        //---------------QUERY PER OTTENERE TUTTE LE MATERIE DI UNA PERSONA PER IL MENU A TENDINA ---------------//
        $query = "SELECT DISTINCT NAME FROM SUBJECTS 
                  INNER JOIN SUBJECT_SESSIONS ON SUBJECTS.ID = SUBJECT_SESSIONS.SUBJECT_ID 
                  INNER JOIN STUDY_SESSIONS ON SUBJECT_SESSIONS.SESSION_ID = STUDY_SESSIONS.SESSION_ID
                  WHERE STUDY_SESSIONS.USER =?";
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

    //---------------QUERY PER AGGIUGRE TEMPO TOTALE DI SESSIONE STUDIO  ---------------//
    //---------------QUERY PER AGGIUGRE TEMPO INZIO DI SESSIONE STUDIO  ---------------//
    //---------------QUERY PER AGGIUGRE TEMPO FINE DI SESSIONE STUDIO  ---------------//


    //---------------QUERY PER MODIFICARE GUADAGNO DELLA SESSOONE DI STUDIO  ---------------//
    //---------------QUERY PER MODIFICARE LA DESCRIZIONE DELLA SESSIONE ---------------//
    //---------------QUERY PER MODIFICARE TEMPO TOTALE DI SESSIONE STUDIO  ---------------//
}
?>