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
    <span>
            <button id="newsub"> + </button>
        </span>
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
            <div> <input type="range" id="stopwatchRange "></div>
            <div id ="stopwatchBottons">
                <button id = "startStopwatch" >Start</button>
                <button id = "resetStopwatch">Reset</button>
            </div>
        </div>
    </div>

    <div class = "split-right">
        <button id = "buttom-Swipe-right ">  > </button>
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
                        <span>
                                        <p id="timeDuration">tempo</p>
                                    </span>
                    </div>
                    <div>
                        <p id="materia_studiata">materia studiata:</p>
                        <span>
                                        <p id="subStudied"></p>
                                    </span>
                    </div>
                    <div>
                        <p id="soldi_ottenuti">soldi ottenuti:</p>
                        <span>
                                        <p id="moneyGotten">soldi</p>
                                    </span>
                    </div>
                    <p></p>
                </div>
                </p>
            </div>
            <div id="descrizione">
                <div>
                    <textarea id ="area_descrizione" rows="4" cols="50" placeholder="Scrivi qui..."></textarea>
                    <div>
                        <span> <p id ="word counter" > 0/300</p>

                    </div>
                </div>


            </div>

            <div >
                    <span class="popup_button">
                    <button id="closePopUp" > yes </button>
                    </span>
                <span class="popup_button">
                        <button id="cancelPopup">  Cancel </button>
                    </span>
            </div>
        </div>
    </div>
</div>


<script>
    const dataTime={
        typeSession:null,
        timeSpent :null,
        money : null,
        subjactName: null,
        description:null,
        season: null
    }

    //gestione timer
    let interval;
    let timeLeft = 1500; /*tempo rimasto : 1500 indica 25 secondi*/
    var isTimerStarted  = false; // false: timer is at max, true:timer is running
    var isStopawatchStarted = false // false : stopwatch is at max , true : stopwatch is running
    var buttonT = document.getElementById("TimerStart");
    var buttonS = document.getElementById("startStopwatch");
    const startTime ="25 : 00" ;

    var timeSpentForMoney =0;
    var timmeSpentForSession = 0;
    var formattedTime;

    const subjectName=null;
    const startTimerElement= document.getElementById("TimerStart");
    const resetTimerElement= document.getElementById("resetTimer");
    const timeTimerElement= document.getElementById("timeTimer");

    //popup
    const closeButtonPopUp = document.getElementById("closePopUp");
    const cancelButtonPopUp = document.getElementById("cancelPopup")
    const popUp =document.getElementById("popup");
    const textPopUp = document.getElementById("area_descrizione");

    var timeDuratioSession =document.getElementById("timeDuration");
    var subSubStudied = document.getElementById("subStudied"); //materia nel popup
    var subEventuallyStudied = document.getElementById("scelta").value; // materia presa dalla select-option
    var moneyMoneyObtained= document.getElementById("moneyGotten")
    const descriptionArea=document.getElementById("area_descrizione");
    const wordCounter = document.getElementById("word counter");
    const  limitWords =20;


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
    const rangeStart =document.getElementById("stopwatchRange ");
    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER SWITCH TRA TIMER E STOPWATCH  ------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////
    displayStopwatch.classList.add("hide");
    swipeLeft.addEventListener("click", ()=>{
        if(!isTimerStarted) {
            swipeCount++;
            toggleButtonTS();
        }

    })
    swipeRight.addEventListener("click", ()=>{
        if(!isTimerStarted) {
            swipeCount++;
            toggleButtonTS();
        }
    })
    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER IL TIMER  --------------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-------------------------EVENTO PER DIRE SE SONO IN STOP OPPURE IN START -------------------------//
    startTimerElement.addEventListener('click', function() {
        subEventuallyStudied=document.getElementById("scelta");
        if(subEventuallyStudied.value !=='') {
            isTimerStarted = true;
            // Verifica lo stato del bottone
            if (buttonT.innerHTML === "Start") {
                blockSelection();
                // Prima volta che è stato cliccato
                console.log('Primo clic');

                console.log(isTimerStarted);
                startTimer(idTimerOrStopwatch);
                // Aggiorna lo stato
                buttonT.innerHTML = "Stop";
                buttonT.setAttribute("aria-label", "Stop");
            } else {

                // Seconda volta che è stato cliccato
                console.log('Secondo clic');
                console.log(isTimerStarted);
                stopTimer(idTimerOrStopwatch);
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
                stopTimer();
                popUp.classList.add("open");//aggiungo il css

            }
        }else
        {
            alert('Cannot reset without a start')
        }
    })
    //-------------------------EVENTO PER DIRE CHIUDERE IL POPUP RESETTANDO -------------------------//
    closeButtonPopUp.addEventListener("click",()=>{
        popUp.classList.remove("open");//aggiungo il css
        if(buttonT.innerHTML==="Stop"){
            buttonT.innerHTML = "Start";
            buttonT.removeAttribute("aria-label");
        }
        resetTimer(idTimerOrStopwatch);
        unlockSelection();
        isTimerStarted=false;

    })
    //-------------------------EVENTO PER DIRE CHIUDERE IL POPUP CONTINUANDO -------------------------//
    cancelButtonPopUp.addEventListener("click",()=>{
        if(buttonT.innerHTML==="Stop"){
            buttonT.innerHTML = "Start";
            buttonT.removeAttribute("aria-label");
        }
        popUp.classList.remove("open");//aggiungo il css
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
    const subChoosen = document.getElementById("scelta");
    var displaySubjects = ["italiano", "matematica","inglese"];
    //-------------------------EVENTO PER FARE IL DISPLAY DELLE MATERIE -------------------------//
    window.addEventListener("DOMContentLoaded", () => {
        populateSelect(displaySubjects);
    });
    //-------------------------EVENTO PER FAGGIUNGERE UNA MATERIA  -------------------------//
    var addSubject;
    const newSubject = document.getElementById("newsub");
    newSubject.addEventListener("click", ()=>{
        addSubject = document.getElementById("add_materie").value;
        console.log(addSubject);
        console.log(addSubject, "ciao");
        if(!isSubPresent(addSubject)){
            console.log("mteria gia inserita");
        }else {
            databaseDelivery(dataTime);
        }
    })
    ////////////////////////////////////////////////////////////////////////////////////////////////
    //-----------------SCRIPT PER IL STOPWATCH -----------------------------------------------------
    ////////////////////////////////////////////////////////////////////////////////////////////////

    if (isStopawatchStarted) {
        rangeStart.addEventListener("input", function() {
            // Ottieni il valore corrente del range
            const rangeValue = this.value;
            const hours = Math.floor(rangeValue / 3600);
            const minutes = Math.floor((rangeValue % 3600) / 60);
            const seconds = rangeValue % 60;

            // Formatta l'ora come stringa e visualizzala nell'elemento timeStopwatch
            timeStopwatchElement.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        });
    }


    startStopwatchElement.addEventListener('click', function() {
        subEventuallyStudied=document.getElementById("scelta");
        if(subEventuallyStudied.value !=='') {
            isStopawatchStarted = true;
            // Verifica lo stato del bottone
            if (buttonS.innerHTML === "Start") {
                blockSelection();
                // Prima volta che è stato cliccato
                console.log('Primo clic');

                console.log(isStopawatchStarted, idTimerOrStopwatch);
                startTimer(idTimerOrStopwatch);
                // Aggiorna lo stato
                buttonS.innerHTML = "Stop";
                buttonS.setAttribute("aria-label", "Stop");
            } else {

                // Seconda volta che è stato cliccato
                console.log('Secondo clic');
                console.log(isStopawatchStarted);
                stopTimer(idTimerOrStopwatch);
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
                stopTimer();
                popUp.classList.add("open");//aggiungo il css
            }
        }else
        {
            alert('Cannot reset without a start')
        }
        console.log("bottone dello stopwatch " , buttonS.innerHTML)

    })
    closeButtonPopUp.addEventListener("click",()=>{
        console.log("bottone dello stopwatch " , buttonS.innerHTML)

        popUp.classList.remove("open");//aggiungo il css
        if(buttonS.innerHTML==="Stop"){
            buttonS.innerHTML = "Start";
            buttonS.removeAttribute("aria-label");
        }
        resetTimer(idTimerOrStopwatch);
        unlockSelection();
        isStopawatchStarted=false;

    })
    //-------------------------EVENTO PER DIRE CHIUDERE IL POPUP CONTINUANDO -------------------------//

    cancelButtonPopUp.addEventListener("click",()=>{
        if(buttonS.innerHTML==="Stop"){
            buttonS.innerHTML = "Start";
            buttonS.removeAttribute("aria-label");
        }
        popUp.classList.remove("open");//aggiungo il css
    })



</script>





<script src="../js/main_timer.js"></script>




<footer>
    <p>Copyright © 2023. All rights reserved   .</p>
</footer>
</body>
</html>