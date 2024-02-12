<?php
session_start();
//Verifica se è impostato un cookie
include("../backend/function_files/verifyCookie.php");
verifyCookie();

//Aggiunta dell'header
include('header.php');

$session = getSession(true);
echo "<h2>Welcome " . $session['firstname'] . " " . $session['lastname'] .  " </h2>" ;
?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link href="../main_dressing.css" rel="stylesheet" type="text/css">
</head>


<body>
<div>
    <span>
        <label for="Testo_materie">Scegli la materia:</label>
        <select id="scelta" name="scelta"></select>
    </span>
    <span>
        <label for="add_materie">Aggiungi una materia:</label>
        <input type="text" id="add_materie" name="Testo_materie">
    </span>
    <span><button id="newsub"> + </button></span>
</div>

<div class="vertical-grid">
    <div class="column left-button">
        <button id="buttom-Swipe-left "> << </button>
    </div>
    <div class="column center">
        <div class="container" id="containertimer">
            <div class="title">
                <h1>Timer</h1>
            </div>
            <p id="timeTimer" class="timer">25:00</p>
            <div > <input type="range" id="TimerRange"></div>
            <div>
                <button id="TimerStart">Start</button>
                <button id="resetTimer">Reset</button>
            </div>
        </div>

        <div class="container" id ="constainerstopwatch">
            <div class="title">
                <h1> Stopwatch</h1>
            </div>
            <p id="timeStopwatch" class ="timer"  >00:00 </p>
            <div id ="stopwatchBottons">
                <button id = "startStopwatch" >Start</button>
                <button id = "resetStopwatch">Reset</button>
            </div>
        </div>

    </div>
    <div class="column right-button">
        <button id="buttom-Swipe-right "> >> </button>
    </div>
</div>
<!-- pop up timer-->
<div class="container_popup" id="popUp">
    <div class="popup" id="popUpContent">

    </div>
</div>


<script>
    const dataTime={
        typeSession: null,
        timeSpent: null,
        money : null,
        subjectName: null,
        description: null,
        season: null,
    };

    // variabili utili


    var isTimerStarted  = false; // false: timer is at max, true:timer is running
    var isTimerDone = false;
    var isStopawatchStarted = false // false : stopwatch is at max , true : stopwatch is running
    var startTimeTI = 1500 ; // default
    var startTimeST =0;
    var formattedTime;
    var  interval;
    var timeSpentForMoney =0;
    var timmeSpentForSession = 0;
    var operationType=null;
    var numberSeason=null;

    //gestione timer
    const subjectName=null;
    const startTimerElement= document.getElementById("TimerStart");
    const resetTimerElement= document.getElementById("resetTimer");
    const timeTimerElement= document.getElementById("timeTimer");
    var buttonT = document.getElementById("TimerStart");
    const rangeStart =document.getElementById("TimerRange");
    rangeStart.value = 5;
    rangeStart.min = 0;
    rangeStart.max = 24;





    //gestione switch tra timer e stopwatch
    const swipeLeft = document.getElementById("buttom-Swipe-left ");
    const swipeRight = document.getElementById("buttom-Swipe-right ");
    var displayTimer = document.getElementById("containertimer");
    var displayStopwatch = document.getElementById("constainerstopwatch");
    var swipeCount =0; // for < > button
    const clocks={
        idTimerOrStopwatch : false,   //0  stopwatch , 1 timer
        idTimerEndOrStop:false ,       //0  end , 1 stop
        timePassed:0,
        startTimeTI : 1500 , // default
        startTimeST :0

    }
    //gestione stopwatch
    const startStopwatchElement= document.getElementById("startStopwatch");
    const resetStopwatchElement= document.getElementById("resetStopwatch");
    const timeStopwatchElement= document.getElementById("timeStopwatch");
    var buttonS = document.getElementById("startStopwatch");

    //gestione tendina delle materie
    var displaySubjects;
    var subChoosen = document.getElementById("scelta");
    const newSubject = document.getElementById("newsub");
    const textMateria = document.getElementById("add_materie");
    var subEventuallyStudied = document.getElementById("scelta"); // materia presa dalla select-option

    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER SWITCH TRA TIMER E STOPWATCH  ------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////
    displayStopwatch.classList.add("hide");
    swipeLeft.addEventListener("click", ()=>{
        if(!isTimerStarted && !isStopawatchStarted)  {
            swipeCount++;
            toggleButtonTS(clocks);
        }

    })
    swipeRight.addEventListener("click", ()=>{
        if(!isTimerStarted && !isStopawatchStarted) {
            swipeCount++;
            toggleButtonTS(clocks);
        }
    })

    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER IL TIMER  --------------------------------------------------------
    //////////////////////////////////////////////////////////////S//////////////////////////////////
    //-------------------------EVENTO LA GESTIONE DEL RANGE PER IL TIMER   -------------------------//
    rangeStart.addEventListener("input",()=> {
        if(!isTimerStarted) {
            rangeStart.classList.add("rangePrevent");
        }
        let timeOnClock = (7200 / rangeStart.max) * rangeStart.value;
        let hours = Math.floor(timeOnClock / 3600);
        var remainingSeconds = timeOnClock % 3600;
        let minutes = Math.floor(remainingSeconds / 60);
        let seconds = remainingSeconds % 60;
        console.log(timeOnClock);

        if (hours) {
            formattedTime = `${hours.toString().padStart(2, "0")} : ${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
        } else {
            formattedTime = `${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
        }
        timeTimerElement.innerText = formattedTime;
        startTimeTI = timeOnClock;


    })
    //-------------------------EVENTO PER DIRE SE SONO IN STOP OPPURE IN START -------------------------//
    startTimerElement.addEventListener('click', function() {
        subChoosen=document.getElementById("scelta");
        if(subChoosen.value !=='') {
            isTimerStarted = true;
            // Verifica lo stato del bottone
            if (buttonT.innerHTML === "Start") {
                blockSelection();
                // Prima volta che è stato cliccato
                console.log('Primo clic');

                console.log(clocks);
                var time = new Date().getTime();
                startClock(clocks,time,null);
                // Aggiorna lo stato
                buttonT.innerHTML = "Stop";
                buttonT.setAttribute("aria-label", "Stop");
            } else {

                // Seconda volta che è stato cliccato
                console.log('Secondo clic');
                console.log(clocks);
                stopClock(clocks);
                // Aggiorna lo stato
                buttonT.innerHTML = "Start";
                buttonT.removeAttribute("aria-label");
            }
        }else{
            alert("choose a subject to study first :)")
        }
    })
    //-------------------------EVENTO PER RESETTARE -------------------------//
    resetTimerElement.addEventListener("click",()=> {
        console.log("resetTimer 2")
        if(isTimerStarted)  {
            {
                //resetTimer(idTimerOrStopwatch);
                stopClock(clocks);
                generatePopUp(1,clocks);
            }
        }else
        {
            alert('Cannot reset without a start')
        }
    })

    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER IL STOPWATCH -----------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////
    startStopwatchElement.addEventListener('click', function() {
        subEventuallyStudied=document.getElementById("scelta");
        if(subEventuallyStudied.value !=='') {
            isStopawatchStarted = true;
            // Verifica lo stato del bottone
            if (buttonS.innerHTML === "Start") {
                blockSelection();
                // Prima volta che è stato cliccato
                console.log('Primo clic');
                var time = new Date().getTime();
                console.log(clocks,time,null);
                startClock(clocks,time);
                // Aggiorna lo stato
                buttonS.innerHTML = "Stop";
                buttonS.setAttribute("aria-label", "Stop");
            } else {

                // Seconda volta che è stato cliccato
                console.log('Secondo clic');
                stopClock(clocks);
                // Aggiorna lo stato
                buttonS.innerHTML = "Start";
                buttonS.removeAttribute("aria-label");
            }
        } else{
            alert("choose a subject to study first :)")
        }
    })
    //-------------------------EVENTO PER RESETTARE -------------------------//
    resetStopwatchElement.addEventListener("click",()=> {
        console.log("counting:",isStopawatchStarted)
        if(isStopawatchStarted)  {
            {
                stopClock(clocks);
                generatePopUp(1,clocks);
            }
        }else
        {
            alert('Cannot reset without a start')
        }
        console.log("bottone dello stopwatch " , buttonS.innerHTML)

    })

    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER LA SCELTA DELLA MATERIA ------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-------------------------EVENTO PER FARE IL DISPLAY DELLE MATERIE -------------------------//
    window.addEventListener("DOMContentLoaded", () => {
        operationType= 3;
        subjectsRequests();

    });
    //-------------------------EVENTO PER FAGGIUNGERE UNA MATERIA  -------------------------//

    var addSubject;
    newSubject.addEventListener("click", ()=> {
        addSubject = document.getElementById("add_materie").value;
        if (!isSubPresent(addSubject)) {
            alert("mteria gia inserita");
        } else {
            textMateria.value = "";
            operationType = 2;
            dataTime['subjectName'] = addSubject;
           // (dataTime,operationType);
            var optionElement = document.createElement("option");
            optionElement.value = addSubject;
            optionElement.textContent = addSubject;
            subChoosen.appendChild(optionElement);
        }
    })
    src ="../backend/fuction_files/query.php";
</script>
<script src="../js/main_timer.js"></script>
<footer>
    <p>Copyright © 2023. All rights reserved   .</p>
</footer>
</body>
</html>