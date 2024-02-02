<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$json_data = file_get_contents('php://input');
$time_studying = json_decode($json_data, true);
echo ("sono nel bak");

require("function_files/session.php");
$session = getSession(true);

// Percorso del file di destinazione
$file = "xrdycftgvhbjknlkmòlnjlbkhvgcfxd.log";

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

    include("function_files/connection.php");
    $con = connect();

    //---------------QUERY PER MODIFICARE I SOLDI TOTALI DELL' UTENTE ---------------//

    $query = "UPDATE users SET MONEY = MONEY + ? WHERE ID =?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ii',$moneyObtainedFromSession, $userId);
    $stmt->execute();
    if ($stmt->affected_rows !== 1) {
        echo "error nella modifica dei soldi dell'utente ";
    }
    $message ="superato la prima query    /n";
    file_put_contents($file, $message);
    //---------------QUERY PER AGGIORNARE LA MATERIA STUDIATA SE NUOVA  ---------------//
    $query = "INSERT INTO subjects (NAME) VALUES (?) ON DUPLICATE KEY UPDATE NAME=NAME";
    $stmt=$con->prepare($query);
    $stmt->bind_param('s',$subjectStudied);
    //Esecuzione della query
    $stmt->execute();
    if ($stmt->affected_rows == 1) {
        $mat = "materia studiata aggiunta o già esistente";
    } else {
        $mat = "error per aggiungere la materia studiata";
    }
    $message ="superato la seconda query    /n";
    file_put_contents($file, $message);
    //---------------QUERY PER OTTENERE TUTTE LE MATERIE DI UNA PERSONA PER IL MENU A TENDINA ---------------//
    $query = "SELECT DISTINCT NAME FROM subjects WHERE ID =?";
    $res = $con->prepare($query);
    $stmt->bind_param('i',$userId);
    $stmt->execute();
    $stmt->bind_result($subjectStudied);

    $subjects = array();
    while($stmt->fetch()) {
        $subjects[] = $subjectStudied;
    }
    $message ="superato la terza query    /n";
    file_put_contents($file, $message);

    //---------------QUERY PER AGGIUGRE TEMPO TOTALE DI SESSIONE STUDIO  ---------------//
    //---------------QUERY PER AGGIUGRE TEMPO INZIO DI SESSIONE STUDIO  ---------------//
    //---------------QUERY PER AGGIUGRE TEMPO FINE DI SESSIONE STUDIO  ---------------//
    $message ="arrivato la quarta query    /n";
    file_put_contents($file, $message);
    $query = "INSERT INTO study_sessions (SESSION_ID, TYPE, DATE, TOTAL_TIME, TOTAL_REWARD, USER, SEASON, DESCRIPTION) VALUES (NULL, ?, CURRENT_TIMESTAMP, ?, ?, ?, ?, ?)";
    $message ="superato la  query    /n";
    file_put_contents($file, $message);
    $stmt = $con->prepare($query);
    $message ="prepare     /n";
    file_put_contents($file, $message);
    $stmt->bind_param('iiiiis', $typesession, $total_time_spent, $total_reward_obtained, $userId, $seasonId, $descriptionSession);
    $message ="bind     /n";
    file_put_contents($file, $message);
    $stmt->execute();
    $message ="execuete     /n";
    file_put_contents($file, $message);
    $message ="superato la quarta query    /n";
    file_put_contents($file, $message);

    $con->close();

    //---------------QUERY PER MODIFICARE GUADAGNO DELLA SESSOONE DI STUDIO  ---------------//
    //---------------QUERY PER MODIFICARE LA DESCRIZIONE DELLA SESSIONE ---------------//
    //---------------QUERY PER MODIFICARE TEMPO TOTALE DI SESSIONE STUDIO  ---------------//
}
?>