<?php
session_start();
if(!function_exists('rethriveData')) {
    function rethriveData()
    {
        require('function_files/connection.php');
        $con = connect();

        require('function_files/session.php');
        $session = getSession(true);
        $userId = $session['id'];
        //non includeva tutti gli utenti se non avevano record associati nelle tabelle transactions e study_sessions.
        // la query restituirà tutte le righe della tabella users, anche se non ci sono record associati nelle tabelle transactions e study_sessions
        //non devo visualizzare solo gli tenti che hanno una relazione in tutte e de la tebelle , ma devo mostrare tutti gli utenti , anche quelli che non hanno interazioni con le teablle, uso left join per avere i null e al massimo non contarli nei count e sum
        // left join : tabella left(users), risultato contengo lo stesso numero di righe di user

        //cerco id, nome , cognome, mail, money, i risiltato della query per trovare il numero di volte in cui prendo un fiore per ogni user e il tempo totale di sessione per ogni user
        //prelevo il numero di piante associate ad ogni utente in trasacion e la nomino numeropiante
        // prendo l'user e la somma dei tempi i oguno degli user e lo chiamo total time
        //cerco sull id

        $data = array();

        $query ="SELECT FIRSTNAME, LASTNAME, EMAIL, MONEY FROM users WHERE users.ID = ?";

        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1){
            $row = $result->fetch_assoc();
            $data['FIRSTNAME'] = $row['FIRSTNAME'];
            $data['LASTNAME'] = $row['LASTNAME'];
            $data['EMAIL'] = $row['EMAIL'];
            $data['MONEY'] = $row['MONEY'];
        }

        $query ="SELECT COUNT(DISTINCT TRANSACTIONS_ID) AS OCCURENCIESPLANT FROM TRANSACTIONS WHERE USER_ID = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $data['OCCURENCIESPLANT'] = $row['OCCURENCIESPLANT'];
        }

        $query ="SELECT SUM(TOTAL_TIME) AS TOTAL_TIME FROM STUDY_SESSIONS WHERE USER = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $data['TOTAL_TIME'] = $row['TOTAL_TIME'];
        }

        $con->close();

        header('Content-Type: application/json');
        echo json_encode($data);

    }
}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    if(isset($data['action'])) {
        switch ($data['action']) {
            case 'rethriveData':
                rethriveData();
                break;
            case 'resetMoney':
                resetMoney($data['email']);
                break;
        }
    }else{
        echo json_encode('Unsupported action');
    }
}