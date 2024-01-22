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
<div>
    <div class="containerTimer">
        <div class="title">
            <h1> Timer</h1>
        </div>
        <p id="timeTimer" class ="timer">25:00</p>
        <div id ="timerBottons">
            <button id = "Timer">Start</button>
            <button id = "resetTimer">Reset</button>
        </div>
    </div>

    <div class="containerStopwatch">
        <div class="title">
            <h1> Stopwatch</h1>
        </div>
        <p id="timeStopwatch" class ="timer">00:00</p>
        <div id ="stopwatchBottons">
            <button id = "Stopwatch" >Start</button>
            <button id = "resetStopwatch">Reset</button>

        </div>
    </div>

</div>
<script>
    function toggleButton(buttonId){
        // Riferimento all'elemento del bottone
        var button = document.getElementById(buttonId);
        console.log(button.innerHTML);
        if(button.innerHTML === "Start"){
            button.innerHTML = "Stop";
            // Impostazione attributo per cambiare colore bottone
            button.setAttribute("aria-label", "Stop");
        }
        else{
            button.innerHTML = "Start";
            button.removeAttribute("aria-label");
        }
    }
</script>
<script>
const startElement= document.getElementById("Timer");
const resetElement= document.getElementById("resetTimer");
const timeElement= document.getElementById("timeTimer");
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
        funzione per stampare a schermo il tempo che scorre ,padStart serve per stampare 0, col lo 0 davanti
        con 2 -> voglio 2 digit e se non ho nulla metto "0" di default
    */
    let formattedTime = `${minutes.toString().padStart(2, "0")}: ${seconds.toString().padStart(2, "0")}`;
    timeElement.innerHTML = formattedTime;
}

function startTimer() {
    /*intervallo che deve essere aggiornato ogni 1000 ms*/
    toggleButton('Timer');
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
    console.log("resetTimer")
    clearInterval(interval);
    timeLeft = 1500;
    updateTimer();
    bottonRound = 0;
    if(startElement_S.innerHTML === "Stop") {
        toggleButton('Timer');
    }
}

function stopTimer() {
    clearInterval(interval);
    toggleButton('Stopwatch');
}
resetElement.addEventListener("click", resetTimer)
</script>
<script>
        const startElement_S= document.getElementById("Stopwatch");
        const resetElement_S= document.getElementById("resetStopwatch");
        const timeElement_S= document.getElementById("timeStopwatch");
        let interval2;
        let bottonRound2 =0;
        let startTime = 0;

        startElement_S.addEventListener('click', function() {
            // Verifica lo stato del bottone
            if (bottonRound2 === 0) {
                // Prima volta che è stato cliccato
                console.log('Primo clic');
                startStopwatch();
                // Aggiorna lo stato
                bottonRound2 = 1;
            } else {
                // Seconda volta che è stato cliccato
                console.log('Secondo clic');
                stopStopwatch();
                // Aggiorna lo stato
                bottonRound2 = 0;
            }
        })

        function updateStopwatch() {
            let currentTime = new Date();
            let elapsedTime = startTime ? Math.floor((currentTime - startTime) / 1000) : 0;
            let minutes = Math.floor(elapsedTime / 60);
            let seconds = elapsedTime % 60;
            /*
                funzione per stampare a schermo il tempo che scorre ,padStart serve per stampare 0, col lo 0 davanti
                con 2 -> voglio 2 digit e se non ho nulla metto "0" di default
            */
            let formattedTime2 = `${minutes.toString().padStart(2, "0")}: ${seconds.toString().padStart(2, "0")}`;
            timeElement_S.innerHTML = formattedTime2;
        }

        function startStopwatch() {
            toggleButton('Stopwatch');
            startTime = new Date();
            /*intervallo che deve essere aggiornato ogni 1000 ms*/
            interval2 = setInterval(() => {
                updateStopwatch();
            }, 1000)
        }

        function resetStopwatch() {
            console.log("resetStopwatch")
            clearInterval(interval2);
            interval2 = undefined;
            startTime = null;
            updateStopwatch();
            bottonRound2 = 0;
            console.log(startElement.innerHTML);
            if(startElement_S.innerHTML === "Stop") {
                toggleButton('Stopwatch');
            }
        }

        function stopStopwatch() {
            clearInterval(interval2);
            toggleButton('Stopwatch');
        }
        resetElement_S.addEventListener("click", resetStopwatch)
    </script>
<footer>
    <p>Copyright © 2023. All rights reserved   .</p>
</footer>
</body>
</html>
