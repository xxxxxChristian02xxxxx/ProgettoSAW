<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_COOKIE['ReMe'])) {
        //fa qualcosa: query per verificare se esiste
        include('backend/function_files/connection.php');
        $con = connect();


        $cookie_val = $_COOKIE['ReMe'];
        $decodedata = json_decode($cookie_val, true);
        $token_val = $decodedata['token_value'];
        $id = $decodedata['id'];
        $query = "SELECT EXPIRE FROM USERS WHERE TOKEN = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $token_val);
        $stmt->execute();

        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $expire = $res->fetch_assoc();

            //Se scaduto rimanda alla pagina di login
            if (date(time()) > $expire['EXPIRE']) {
                header("Location: frontend/login.php");
            } else {
                include('backend/function_files/session.php');
                setSession($id);
            }
        }else{
            //todo: create error
        }
        $stmt->close();
    }

    include('frontend/header.php');
    include('backend/function_files/session.php');
    $session = getSession(true);
    echo "<h2>Welcome " . $session['firstname'] . " " . $session['lastname'] .  " </h2>" ;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link href='dressing.css' rel='stylesheet' type='text/css'>
</head>


<body>
<div id="header">
    <script>
        $(function () {
            $("#header").load("public_header.html");
        });
    </script>
</div>
<div class="containerStopwatch">
    <div class="title">
        <h1> Timer</h1>
    </div>
    <p id="time" class ="timer">25:00</p>
    <div id ="stopwatchBottons">
        <button id = "start" > Start</button>
        <button id = "reset"> Reset</button>

    </div>
</div>
<script>
const startElement= document.getElementById("start");
const resetElement= document.getElementById("reset");
const timeElement= document.getElementById("time");
let interval;
let timeLeft = 1500; /*tempo rimasto : 1500 indica 25 secondi*/
var bottonRound =0;


startElement.addEventListener('click', function() {
    // Verifica lo stato del bottone
    if (bottonRound === 0) {
        // Prima volta che è stato cliccato
        console.log('Primo clic');
        startTimer();
        // Aggiorna lo stato
        bottonRound = 1;
    } else {
        // Seconda volta che è stato cliccato
        console.log('Secondo clic');
        stopTimer();
        // Aggiorna lo stato
        bottonRound = 0;
    }
})

function updateTimer() {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;
    /*
        funzione per stampare a schermo il tempo che scorre ,padStart serve per stampare 01, col lo 0 davanti
        con 2 -> voglio 2 digit e se nnon ho nulla metto "0" idi default
    */
    let formattedTime = `${minutes.toString().padStart(2, "0")}: ${seconds.toString().padStart(2, "0")}`;
    timeElement.innerHTML = formattedTime;
}

function startTimer() {
    /*intervallo che deve essere aggiornato ogni 1000 ms*/

    interval = setInterval(() => {
        timeLeft--;
        updateTimer();
        if (timeLeft === 0) {
            /*una vlta finito il timer pulisco l'intervallo*/
            clearInterval(interval);
            alert("finito");
            timeLeft = 1500;
            updateTimer();
        }
    }, 1000)

}

function resetTimer() {
    console.log("reset")
    clearInterval(interval);
    timeLeft = 1500;
    updateTimer();
    bottonRound = 0;
}

function stopTimer() {
    clearInterval(interval);
}


resetElement.addEventListener("click", resetTimer)
</script>

<footer>
    <p>Copyright © 2023. All rights reserved.</p>
</footer>
</body>
</html>
