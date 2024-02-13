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
                <h1 id ="timerTitle">Timer</h1>
            </div>
            <p id="timeTimer" class="timer"></p>
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
<div class="container_popup" id="popUpMain">

    <div class="popup" id="popUpContentMain"></div>
</div>


   <script>
    const dataTime={    //per db
        typeSession: null,
        timeSpent: null,
        money : null,
        subjectName: null,
        description: null,

       // season: null,

    };

    function swipe(clocks){
        const swipeLeft = document.getElementById("buttom-Swipe-left ");
        const swipeRight = document.getElementById("buttom-Swipe-right ");
        var displayTimer = document.getElementById("containertimer");
        var displayStopwatch = document.getElementById("constainerstopwatch");
        var swipeCount =0; // for < > button
        displayStopwatch.classList.add("hide");
        swipeLeft.addEventListener("click", ()=>{
            if(!clocks['isTimerStarted'] && !clocks['isStopawatchStarted'])  {
                swipeCount++;
                toggleButtonTS(clocks,displayTimer,displayStopwatch,swipeCount);
            }

        })
        swipeRight.addEventListener("click", ()=>{
            if(!clocks['isTimerStarted'] && !clocks['isStopawatchStarted']) {
                swipeCount++;
                toggleButtonTS(clocks,displayTimer,displayStopwatch,swipeCount);
            }
        })
    }
    function sessionTimer(clocks){
        //gestione timer
        const startTimerElement= document.getElementById("TimerStart");
        const resetTimerElement= document.getElementById("resetTimer");
        const timeTimerElement= document.getElementById("timeTimer");
        var buttonT = document.getElementById("TimerStart");
        const rangeStart =document.getElementById("TimerRange");
        rangeStart.value = 5;
        rangeStart.min = 1;
        rangeStart.max = 24;
        updateTimer(clocks,clocks['startTimeTI'])
        rangeStart.value = (clocks['startTimeTI'] * rangeStart.max)/ 7200 ;
        rangeStart.addEventListener("input",()=> {

            let formattedTime
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
            clocks['startTimeTI']= timeOnClock;

        })
        //-------------------------EVENTO PER DIRE SE SONO IN STOP OPPURE IN START -------------------------//
        startTimerElement.addEventListener('click', function() {

           var subChoosen=document.getElementById("scelta");

            rangeStart.classList.add("rangePrevent");
            if(subChoosen.value !=='') {
                clocks['isTimerStarted'] = true;
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
            if(clocks['isTimerStarted'])  {
                {
                    stopClock(clocks);
                    generatePopUp(1,clocks);
                    //resetClock(clocks);

                }
            }else
            {
                alert('Cannot reset without a start')
            }
        })

    }
    function sessionStopwatch(clocks){
        const startStopwatchElement= document.getElementById("startStopwatch");
        const resetStopwatchElement= document.getElementById("resetStopwatch");
        var  subEventuallyStudied=document.getElementById("scelta");
        var buttonS = document.getElementById("startStopwatch");

        startStopwatchElement.addEventListener('click', function() {
            if(subEventuallyStudied.value !=='') {
                clocks['isStopawatchStarted'] = true;
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
            if(clocks['isStopawatchStarted'])  {
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
    }
    function subjectAdd(displaySubjects){
        var subChoosen = document.getElementById("scelta");
        const newSubject = document.getElementById("newsub");
        //var subEventuallyStudied = document.getElementById("scelta"); // materia presa dalla select-option
        var addSubject;
        newSubject.addEventListener("click", ()=> {
            const textMateria = document.getElementById("add_materie");
            addSubject = document.getElementById("add_materie").value;
            console.log(addSubject)
            if (!isSubPresent(addSubject,subChoosen)||addSubject==="") {
                alert("mteria gia inserita");
            } else {
                textMateria.value = "";

                dataTime['subjectName'] = addSubject;
                databaseDelivery(dataTime,2);
                var optionElement = document.createElement("option");
                optionElement.value = addSubject;
                optionElement.textContent = addSubject;
                subChoosen.appendChild(optionElement);
                console.log(addSubject);
            }
        })
    }


    window.addEventListener("DOMContentLoaded", () => {

        const clocks={      //di gestione
            idTimerOrStopwatch : false,   //0  stopwatch , 1 timer
            idTimerEndOrStop:false ,      //0  end , 1 stop
            startTimeTI : 10, // default
            startTimeST :0,     //default
            isTimerStarted  : false,// false: timer is at max, true:timer is running
            isStopawatchStarted : false, // false : stopwatch is at max , true : stopwatch is running
            interval:0,
            shortBreak: 20,
            middleBreak:900,
            longBreak :1800
        }
        var displaySubjects=[];
        subjectsRequests(displaySubjects);
        swipe(clocks);
        sessionTimer(clocks);
        sessionStopwatch(clocks);
        subjectAdd(displaySubjects);
    });
</script>
<script src="../js/main_timer.js"></script>

<footer>
    <p>Copyright © 2023. All rights reserved   .</p>
</footer>
</body>
</html>