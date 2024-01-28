<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$json_data = file_get_contents('php://input');
$time_studying = json_decode($json_data, true);

require("backend/function_files/session.php");
$session = getSession(true);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //Memorizzazione in variabili dei dati inseriti nel form
    $userId =$session['id'];
    $moneyObtainnedFromSession=$json_data['money'];
    $subjectStudied =$json_data['subjactName'];
    $tiypesession =$json_data['typeSession'];
    $total_time_spent=$json_data['timeSpent'];
    $total_reward_obtained=$json_data['money'];
    $seasonId = $json_data['season'];
    $descriptionSession=$json_data[' description'];
    include("function_files/connection.php");
    $con = connect();


    //---------------QUERY PER MODIFICARE I SOLDI TOTALI DELL' UTENTE ---------------//

    $query = "UPDATE users SET MONEY =MONEY + '$moneyObtainnedFromSession' WHERE AND ID =?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s',$userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 1) {
        echo "error nella modifica dei soldi dell'utente ";
    }



    //---------------QUERY PER AGGIURNARE LA MATERIA STUDIATA SE NUOVA  ---------------//
    $query = "INSERT INTO subjects (NAME) VALUES ('?')";
    $stmt=$con->prepare($query);
    $stmt->bind_param('s',$subjectStudied);
    //Esecuzione della query
    $stmt->execute();
    if ($con->affected_rows == 1) {
        $con->close();
    } else {
        echo "error per aggiungere la materia studiata";
    }

    //---------------QUERY PER OTTENERE TUTTE LE MATERIE DI UNA PERSONA PER IL MENU A TENDINA ---------------//
    $query = "SELECT DISTINCT NAME FROM subjects WHERE ID ='$userId' ";
    $res = $con->query($query);
    $row = $res->fetch_assoc();
    if($con->affected_rows ===0){
        echo “no rows inserted/updated/canceled”;
    }

    //---------------QUERY PER AGGIUGRE TEMPO TOTALE DI SESSIONE STUDIO  ---------------//
    //---------------QUERY PER AGGIUGRE TEMPO INZIO DI SESSIONE STUDIO  ---------------//
    //---------------QUERY PER AGGIUGRE TEMPO FINE DI SESSIONE STUDIO  ---------------//

    $query = "    INSERT INTO study_sessions (TYPE,TOTAL_TIME,TOTAL_REWARD,USER,SEASON,DSCRIPTION) 
                VALUES ('?','?','?','?','?','?')";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i' ,'i','i','i','i','s', $tiypesession,$total_time_spent,$total_reward_obtained,$userId,$seasonId,$descriptionSession);
    if ($con->affected_rows == 1) {
        $con->close();
    } else {
        echo "error per aggiungere la materia studiata";
    }






    //---------------QUERY PER MODIFICARE GUADAGNO DELLA SESSOONE DI STUDIO  ---------------//
    //---------------QUERY PER MODIFICARE LA DESCRIZIONE DELLA SESSIONE ---------------//
    //---------------QUERY PER MODIFICARE TEMPO TOTALE DI SESSIONE STUDIO  ---------------//








}
?>