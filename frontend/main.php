<?php
    session_start();
    //Verifica che la sessione sia attiva
    include('../backend/function_files/session.php');
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

<div class ="split_container">
    <div class = "split-left">
        <button id = "buttom-Swipe-left "> << </button>
    </div>
    <div class = "split-center">
        <div class="containerTimer" id ="conainertimer">
            <div class="title">
                <h1> Timer</h1>
            </div>
            <p id="timeTimer" class ="timer">25:00</p>
            <p id="prova" ></p>
            <div> <input type="range" id="TimerRange "></div>
            <div id ="timerBottons">
                <button id = "TimerStart">Start</button>
                <button id = "resetTimer">Reset</button>
            </div>
        </div>
        <div class="containerStopwatch" id ="constainerstopwatch">
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

    <div class = "split-right">
        <button id = "buttom-Swipe-right ">  >> </button>
    </div>
</div>
<!-- pop up timer-->
<div class="container_popup">
    <div class="popup" id="popup">
        <div class="popup-inner">
            <h2> Are you sure to leave? </h2>
            <div id ="statistiche_sessioone_studio ">
                <p>
                    <div>
                        <div>
                            <p id="durata_session">durata sessione:</p>
                            <span><p id="timeDuration">tempo</p></span>
                        </div>
                        <div>
                            <p id="materia_studiata">materia studiata:</p>
                            <span><p id="subStudied"></p></span>
                        </div>
                        <div>
                            <p id="soldi_ottenuti">soldi ottenuti:</p>
                            <span><p id="moneyGotten">soldi</p></span>
                        </div>
                    </div>
                </p>
            </div>
            <div id="descrizione">
                <div>
                    <textarea id ="area_descrizione" rows="4" cols="50" placeholder="Scrivi qui..."></textarea>
                    <div> <p id ="word counter" > 0/300</p></div>
                </div>
            </div>
            <div >
                <span class="popup_button"> <button id="closePopUp" > yes </button> </span>
                <span class="popup_button"> <button id="cancelPopup">  Cancel </button> </span>
            </div>
        </div>
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
        operationType: null,
    };

    // variabili utili
    let interval;
    var isTimerStarted  = false; // false: timer is at max, true:timer is running
    var isStopawatchStarted = false // false : stopwatch is at max , true : stopwatch is running
    var startTimeTI = 1500 ; // default
    var startTimeST =0;
    let timeGone =0 ;
    var formattedTime;
    var isTimerDone = false;
    var timeSpentForMoney =0;
    var timmeSpentForSession = 0;

    //gestione timer
    const subjectName=null;
    const startTimerElement= document.getElementById("TimerStart");
    const resetTimerElement= document.getElementById("resetTimer");
    const timeTimerElement= document.getElementById("timeTimer");
    var buttonT = document.getElementById("TimerStart");
    const rangeStart =document.getElementById("TimerRange ");
             rangeStart.value = 5;
             rangeStart.min = 0;
             rangeStart.max = 24;
    var time;

    //popup
    const closeButtonPopUp = document.getElementById("closePopUp");
    const cancelButtonPopUp = document.getElementById("cancelPopup")
    const popUp =document.getElementById("popup");
    const textPopUp = document.getElementById("area_descrizione");
    const prova=document.getElementById("prova");

    var timeDuratioSession =document.getElementById("timeDuration");
    var subSubStudied = document.getElementById("subStudied"); //materia nel popup
    var subEventuallyStudied = document.getElementById("scelta"); // materia presa dalla select-option
    var moneyMoneyObtained= document.getElementById("moneyGotten")
    const descriptionArea=document.getElementById("area_descrizione");
    const wordCounter = document.getElementById("word counter");
    const  limitWords =300;


    //gestione switch tra timer e stopwatch
    const swipeLeft = document.getElementById("buttom-Swipe-left ");
    const swipeRight = document.getElementById("buttom-Swipe-right ");
    var displayTimer = document.getElementById("conainertimer");
    var displayStopwatch = document.getElementById("constainerstopwatch");
    var swipeCount =0; // for < > button
    var idTimerOrStopwatch = false ; //0  stopwatch , 1 timer

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
    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER SWITCH TRA TIMER E STOPWATCH  ------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////
    displayStopwatch.classList.add("hide");
    swipeLeft.addEventListener("click", ()=>{
        if(!isTimerStarted && !isStopawatchStarted)  {
            swipeCount++;
            toggleButtonTS();
        }

    })
    swipeRight.addEventListener("click", ()=>{
        if(!isTimerStarted && !isStopawatchStarted) {
            swipeCount++;
            toggleButtonTS();
        }
    })

    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER IL TIMER  --------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-------------------------EVENTO LA GESTIONE DEL RANGE PER IL TIMER   -------------------------//
    rangeStart.addEventListener("input",()=> {

        let timeOnClock = (7200/rangeStart.max) * rangeStart.value;
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

                console.log(isTimerStarted);
                time = new Date().getTime();
                startClock(idTimerOrStopwatch);
                // Aggiorna lo stato
                buttonT.innerHTML = "Stop";
                buttonT.setAttribute("aria-label", "Stop");
            } else {

                // Seconda volta che è stato cliccato
                console.log('Secondo clic');
                console.log(isTimerStarted);
                stopClock(idTimerOrStopwatch);
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
                showStudySession();
                stopClock(0);
                popUp.classList.add("open");//aggiungo il css
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
                time = new Date().getTime();
                startClock(idTimerOrStopwatch);
                // Aggiorna lo stato
                buttonS.innerHTML = "Stop";
                buttonS.setAttribute("aria-label", "Stop");
            } else {

                // Seconda volta che è stato cliccato
                console.log('Secondo clic');
                console.log(isStopawatchStarted);
                stopClock(idTimerOrStopwatch);
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
                showStudySession();
                stopClock();
                popUp.classList.add("open");//aggiungo il css
            }
        }else
        {
            alert('Cannot reset without a start')
        }
        console.log("bottone dello stopwatch " , buttonS.innerHTML)

    })

    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER IL POPUP  --------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////
    closeButtonPopUp.addEventListener("click",()=>{
        popUp.classList.remove("open");//aggiungo il css
        if(buttonT.innerHTML==="Stop"){
            buttonT.innerHTML = "Start";
            buttonT.removeAttribute("aria-label");
        }
        if(buttonS.innerHTML==="Stop"){
            buttonS.innerHTML = "Start";
            buttonS.removeAttribute("aria-label");
        }
        isTimerDone =false;
        resetClock(idTimerOrStopwatch);
        textPopUp.value ="";
        textPopUp.placeholder ="scrivi qui ...";
        unlockSelection();
        isTimerStarted=false;
        isStopawatchStarted=false;

    })
    //-------------------------EVENTO PER DIRE CHIUDERE IL POPUP CONTINUANDO -------------------------//
    cancelButtonPopUp.addEventListener("click",()=>{
        if(!isTimerDone) {
            if (buttonT.innerHTML === "Stop") {
                buttonT.innerHTML = "Start";
                buttonT.removeAttribute("aria-label");
            }
            if (buttonS.innerHTML === "Stop") {
                buttonS.innerHTML = "Start";
                buttonS.removeAttribute("aria-label");
            }
            popUp.classList.remove("open");//aggiungo il css
        }
    })
    //-------------------------EVENTO CONTARE NUMERO CARATTERI NELLA SEZIONE DESCRIZIONE  -------------------------//
    descriptionArea.addEventListener("keydown", function (e) {
        const text = descriptionArea.value;

        // Se la lunghezza del testo supera il limite massimo e il tasto non è backspace o delete
        if (text.length >= limitWords && e.key !== 'Backspace' && e.key !== 'Delete') {
            e.preventDefault(); // Impedisce all'utente di digitare oltre il limite
        }
    });
    descriptionArea.addEventListener("paste", function (e) {
        const text = e.clipboardData.getData('text/plain');

        // Se la lunghezza del testo incollato supera il limite massimo
        if ((descriptionArea.value.length + text.length) > limitWords) {
            e.preventDefault(); // Impedisce all'utente di incollare testo oltre il limite
        }
    });
    descriptionArea.addEventListener("input", function (e) {
        const text = descriptionArea.value;
        // Se la lunghezza del testo supera il limite massimo
        if (text.length > limitWords) {
            descriptionArea.value = text.slice(0, limitWords); // Tronca il testo al limite massimo
        }
        wordCounter.textContent = text.length + "/" + limitWords; // Aggiorna il conteggio dei caratteri
    });

    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER LA SCELTA DELLA MATERIA ------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////



    //-------------------------EVENTO PER FARE IL DISPLAY DELLE MATERIE -------------------------//
    window.addEventListener("DOMContentLoaded", () => {
        dataTime['operationType'] = 3;
        subjectsRequests(dataTime);
    });
    //-------------------------EVENTO PER FAGGIUNGERE UNA MATERIA  -------------------------//

    var addSubject;
    newSubject.addEventListener("click", ()=> {
        addSubject = document.getElementById("add_materie").value;

        if (!isSubPresent(addSubject)) {
            alert("mteria gia inserita");
        } else {
            textMateria.value = "";
            dataTime['operationType'] = 2;
            dataTime['subjectName'] = addSubject;
            databaseDelivery(dataTime);
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