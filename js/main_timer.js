//-------------------------FUNZIONE VEDERE SE LA MATERIA AGGIUNTA è VALIDA    -------------------------//
function isSubPresent(addSubject, subChoosen) {
    const options = subChoosen.options; // Get an array-like object of all the options
    for (let i = 0; i < options.length; i++) {
        if(options[i].innerText===addSubject){
            return false
        }
    }
    return true;


}

function blockSelection() {
    var subChoosen = document.getElementById("scelta");
    subChoosen.disabled = true;
}

function unlockSelection() {
    var subChoosen = document.getElementById("scelta");
    subChoosen.disabled = false;
}

//-------------------------FUNZIONE PER IL PER TIMER E STOPWATCH -------------------------//
function toggleButtonTS(typeClock, displayTimer, displayStopwatch, swipeCount) {

    if ((swipeCount % 2) === 0) {
        displayTimer.classList.remove("hide");
        displayStopwatch.classList.add("hide");
        typeClock['idTimerOrStopwatch'] = false;
    } else {
        displayStopwatch.classList.remove("hide");
        displayTimer.classList.add("hide");
        typeClock['idTimerOrStopwatch'] = true;
    }
}

//-------------------------FUNZIONE PER IL TOGGLE TASTO START -------------------------//
function toggleButton(buttonId) {
    // Riferimento all'elemento del bottone
    var button = document.getElementById(buttonId);
    if (button.innerHTML !== 'Start') {
        button.innerHTML = "Stop";
        // Impostazione attributo per cambiare colore bottone
        button.setAttribute("aria-label", "Stop");
    } else {
        button.innerHTML = "Start";
        button.removeAttribute("aria-label");
    }
}

function showStudySession() {
    var timeDuratioSession = document.getElementById("timeDuration");
    var subSubStudied = document.getElementById("subStudied"); //materia nel popup
    var moneyMoneyObtained = document.getElementById("moneyGotten")
    var subChoosen = document.getElementById("scelta");

    if(dataTime['timeSpent']<60){
        timeDuratioSession.innerHTML = dataTime['timeSpent'] + " secondi";
    }else if(dataTime['timeSpent']>60 && dataTime['timeSpent']< 3600){
        timeDuratioSession.innerHTML  = Math.floor(dataTime['timeSpent'] / 60) + " minuti" ;
    }else{
        timeDuratioSession.innerHTML = Math.floor(dataTime['timeSpent'] / 3600) + " ore " + Math.floor((dataTime['timeSpent'] % 3600) / 60) + " minuti";
    }
    moneyMoneyObtained.innerHTML = dataTime['money'];
    subSubStudied.innerHTML = subChoosen.value;
}
function populateSelect(options) {
    //let gridHtml = '';
    let subEventuallyStudied = document.getElementById("scelta");
    options.forEach(op => {
        subEventuallyStudied.appendChild(generateOptions(op));
    })
}
function generateOptions(option) {
    let optionElement = document.createElement("option");
    optionElement.value = option;
    optionElement.textContent = option;
    return optionElement;
}
function generatePopUp(popType, typeClock, timeBreak) {
    const popUp = document.getElementById('popUpMain');
    const popUpContent = document.getElementById('popUpContentMain');
    if (popUp && popUpContent) {
        switch (popType) {
            case 1:
                sessionPopUpAssembling(popUpContent, 1);
                popUpContent.classList.add("open");//aggiungo il css
                sessionPopUpManager(popUpContent, typeClock, timeBreak);
                break;
            case 2:
                sessionPopUpAssembling(popUpContent, 2);
                popUpContent.classList.add("open");//aggiungo il css
                breakPopUpManager(popUpContent, typeClock);
                break;
        }
    }
}

function sessionPopUpAssembling(popUpContent, typePopUp) {
    let gridHtml = '';
    if (typePopUp === 1) {
        gridHtml += generatePopUpSession();
    } else if (typePopUp === 2) {
        gridHtml += generatePopUpBreak();
    }
    popUpContent.innerHTML = gridHtml;
}

function generatePopUpSession() {
    return `
    <div class="popup-inner">
            <h2  class="popup-title"> Your Statistics </h2>
                
                <div class="infoPopup">
                    <div>
                        <p id="durata_session" class="dataText">Duration session:</p>
                        <span><p id="timeDuration" >tempo</p></span>
                    </div>
                    <div>
                        <p id="materia_studiata"  class="dataText">Subjects studied:</p>
                        <span><p id="subStudied"></p></span>
                    </div>
                    <div>
                        <p id="soldi_ottenuti" class="dataText">Money earned:</p>
                        <span><p id="moneyGotten" >soldi</p></span>
                    </div>
            
                    <div id="descrizione" class ="description">
                        <div>
                            <textarea id ="area_descrizione" rows="4" cols="50" placeholder="Add a short description..."></textarea>
                            <div> <p id ="word counter" > 0/300</p></div>
                        </div>
                    </div>
                </div>
                <div class="buttonsPopup">
                    <span > <button  class="popup_button_left" id="closePopUp" > yes </button> </span>
                    <span > <button id="cancelPopup" class="popup_button_right">  Cancel </button> </span>
                </div>
        </div>
`;
}

function sessionPopUpManager(popUpContent, typeClock, timeBreakStart) {
    unlockSelection();

    const descriptionArea = document.getElementById("area_descrizione");
    const wordCounter = document.getElementById("word counter");
    const limitWords = 300;
    const closeButtonPopUp = document.getElementById("closePopUp");
    const cancelButtonPopUp = document.getElementById("cancelPopup")
    const textPopUp = document.getElementById("area_descrizione");
    var buttonT = document.getElementById("TimerStart");
    var buttonS = document.getElementById("startStopwatch");

    showStudySession();

    closeButtonPopUp.addEventListener("click", () => {
        popUpContent.classList.remove("open");//aggiungo il css
        if (buttonT.innerHTML === "Stop") {
            buttonT.innerHTML = "Start";
            buttonT.removeAttribute("aria-label");
        }
        if (buttonS.innerHTML === "Stop") {
            buttonS.innerHTML = "Start";
            buttonS.removeAttribute("aria-label");
        }
        dataTime['description']=descriptionArea.value;

        resetClock(typeClock,"timerStop");
        textPopUp.value = "";
        textPopUp.placeholder = "scrivi qui ...";
        typeClock['isTimerStarted'] = false;
        typeClock['isStopawatchStarted'] = false;
        if (typeClock['idTimerEndOrStop']) {
            let timeBreak = new Date().getTime();
            startClock(typeClock, timeBreak, timeBreakStart);
        }

    })
    //-------------------------EVENTO PER DIRE CHIUDERE IL POPUP CONTINUANDO -------------------------//
    cancelButtonPopUp.addEventListener("click", () => {
        if (!typeClock['idTimerEndOrStop']) {
            if (buttonT.innerHTML === "Stop") {
                buttonT.innerHTML = "Start";
                buttonT.removeAttribute("aria-label");
            }
            if (buttonS.innerHTML === "Stop") {
                buttonS.innerHTML = "Start";
                buttonS.removeAttribute("aria-label");
            }
            popUpContent.classList.remove("open");//aggiungo il css
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

}
function generatePopUpBreak() {
    return `
    <div class="popup-inner"> 
        <div id="breakTime" >
            <h2 class="popup-title">Break Time</h2>
            <div class="textBreakContainer">
                <p class="dataText" >You have accomplished your goal. Take a rest.</p>
                <p class="dataText" >Choose how long your break is.</p>
            </div>
            <div class="buttonsPopupBreak">
                <button class ="break" id="break5mins" >5 mins</button>
                <button id="break15mins" class="break" style="">15 mins</button>
                <button id="break30mins" class="break" style="" >30 mins</button>
            </div>

        </div>
    </div>`
}

function breakPopUpManager(popUpContent, typeClock) {

    const break5minsButton = document.getElementById('break5mins');
    const break15minsButton = document.getElementById('break15mins');
    const break30minsButton = document.getElementById('break30mins');
    //typeClock['timeSpent'] =4000;
    break15minsButton.style.display="none";
    break30minsButton.style.display="none";
   if ((typeClock['timeSpent'] >= 1800) && (typeClock['timeSpent'] < 3600)) {
        break15minsButton.removeAttribute("style");
    } else if (typeClock['timeSpent'] >= 3600) {
        break30minsButton.removeAttribute("style");
        break15minsButton.removeAttribute("style");
    }
    break5minsButton.addEventListener('click', () => {
        // handle 5 mins break
        let timeBreakStart = typeClock['shortBreak'];
        typeClock['idTimerOrStopwatch'] = false;
        popUpContent.classList.remove("open");
        generatePopUp(1, typeClock, timeBreakStart);
        unlockSelection();
        break15minsButton.style.display="none";
        break30minsButton.style.display="none";

    });

    break15minsButton.addEventListener('click', () => {
        let timeBreakStart = typeClock['middleBreak'];
        typeClock['idTimerOrStopwatch'] = false;
        popUpContent.classList.remove("open");
        generatePopUp(1, typeClock, timeBreakStart);
        unlockSelection();
        break15minsButton.style.display="none";
        break30minsButton.style.display="none";
    });

    break30minsButton.addEventListener('click', () => {
        let timeBreakStart= typeClock['longBreak'];
        typeClock['idTimerOrStopwatch'] = false;
        popUpContent.classList.remove("open");
        generatePopUp(1, typeClock, timeBreakStart);
        unlockSelection();
        break15minsButton.style.display="none";
        break30minsButton.style.display="none";
    });

}

//-------------------------FUNZIONE PER FARE L'UPDATE DEL TIMER -------------------------//
function updateTimer(typeClock, timeGone) {
    let timeTimerElement = document.getElementById("timeTimer");
    let timeStopwatchElement = document.getElementById("timeStopwatch");
    let formattedTime;
    let hours = Math.floor(timeGone / 3600);
    let remainingSeconds = timeGone % 3600;
    let minutes = Math.floor(remainingSeconds / 60);
    let seconds = remainingSeconds % 60;

    if (hours) {
        formattedTime = `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
    } else {
        formattedTime = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
    }
    if (typeClock['idTimerOrStopwatch']) {
        timeStopwatchElement.innerHTML = formattedTime;
    } else {
        timeTimerElement.innerHTML = formattedTime;
    }

}


//-------------------------FUNZIONE PER IL INZIARE E STOPPARE IL TIMER IL TIMER -------------------------//
function startClock(typeClock, time, timeBreakStart) {
    var timeGone = 0;
    if (typeClock['idTimerOrStopwatch']) {    /*intervallo che deve essere aggiornato ogni 1000 ms*/
        toggleButton('startStopwatch');

        typeClock['interval'] = setInterval(() => {
            const currentTime = new Date();
            const diff = currentTime - time;
            const secondsPassed = Math.floor(diff / 1000);
            timeGone = typeClock['startTimeST'] + secondsPassed;
            dataTime['timeSpent']++;
            updateMoney();
            updateTimer(typeClock, timeGone);

        }, 1000)
    } else {
        if (!typeClock['idTimerEndOrStop']) {
            toggleButton('TimerStart');
            typeClock['interval'] = setInterval(() => {
                const currentTime = new Date();
                const diff = currentTime - time;
                const secondsPassed = Math.floor(diff / 1000);
                timeGone = typeClock['startTimeTI'] - secondsPassed;
                dataTime['timeSpent']++;
                updateTimer(typeClock, timeGone);
                updateMoney();
                if (timeGone === 0) {
                    clearInterval(typeClock['interval']);
                    stopClock(typeClock);
                    typeClock['idTimerEndOrStop'] = true;
                    generatePopUp(2, typeClock);


                }
            }, 1000)
        } else {
            let title = document.getElementById("timerTitle");
            let range =document.getElementById("TimerRange");
            let startT =document.getElementById("TimerStart")
            let resetT = document.getElementById("resetTimer")
            let startS =document.getElementById("startStopwatch")
            let resetS = document.getElementById("resetStopwatch")
            let buttonSx=document.getElementById("buttom-Swipe-left")
            let buttonRx=document.getElementById("buttom-Swipe-right")
            let header = document.getElementById("privateheaderButton");


            range.classList.add("rangePrevent");
            startT.classList.add("rangePrevent");
            resetT.classList.add("rangePrevent");
            startS.classList.add("rangePrevent");
            resetS.classList.add("rangePrevent");
            buttonSx.classList.add("rangePrevent");
            buttonRx.classList.add("rangePrevent");
            header.classList.add("rangePrevent");
            title.innerText = "Break";
            typeClock['idTimerEndOrStop'] = false;
            toggleButton('TimerStart');
            let timeGone = 0;
            updateTimer(typeClock, timeBreakStart);
            typeClock['interval'] = setInterval(() => {
                const currentTime = new Date();
                const diff = currentTime - time;
                const secondsPassed = Math.floor(diff / 1000);
                timeGone = timeBreakStart - secondsPassed;
                updateTimer(typeClock, timeGone);
                if (timeGone === 0) {
                    clearInterval(typeClock['interval']);
                    title.innerText = "Timer";
                    resetClock(typeClock,"break");

                    range.classList.remove("rangePrevent");
                    startT.classList.remove("rangePrevent");
                    resetT.classList.remove("rangePrevent");
                    startS.classList.remove("rangePrevent");
                    resetS.classList.remove("rangePrevent");
                    buttonSx.classList.remove("rangePrevent");
                    buttonRx.classList.remove("rangePrevent");
                    header.classList.remove("rangePrevent");


                }
            }, 1000)
        }
    }
}

//-------------------------FUNZIONE PER IL RESETTARE IL TIMER -------------------------//
function resetClock(typeClock,option) {
    clearInterval(typeClock['interval']);
    if(option==="timerStop"){
        var subEventuallyStudied = document.getElementById("scelta");
        dataTime['typeSession'] = typeClock['idTimerOrStopwatch'];
        dataTime['subjectName'] = subEventuallyStudied.value;
        databaseDelivery(dataTime, 1);
    }
    let timeGone;
    if (typeClock['idTimerOrStopwatch']) {
        timeGone = 0;
    } else {
        timeGone = typeClock['startTimeTI'];
    }
    dataTime['timeSpent'] = 0;
    updateTimer(typeClock, timeGone);
    dataTime['money'] = 0;
    var range = document.getElementById("TimerRange");
    range.classList.remove("rangePrevent");

}

//-------------------------FUNZIONE PER FERMARE IL TIMER  -------------------------//
function stopClock(typeClock) {
    clearInterval(typeClock['interval']);
    if (typeClock['idTimerOrStopwatch']) {
        toggleButton('startStopwatch');

    } else {
        toggleButton('TimerStart');
    }
}

function databaseDelivery(json_data, operationType) {
    let Action;
    switch (operationType) {
        case 1:
            Action = 'addSessionStudied';
            break;
        case 2:
            Action = 'updateSubject';
            break;

    }
    fetch('../backend/be_main.php', { // dico il percorso del file di back end
        method: 'POST', //metodo get o post
        headers: {
            'Content-Type': 'application/json' // specifico la uso
        },
        body: JSON.stringify({json_data, action: Action}) // encode
    })

        .catch(error => {
            console.error('Error:', error);
        });

}

function subjectsRequests(displaySubjects) {
    fetch('../backend/be_main.php', { // dico il percorso del file di back end
        method: 'POST', //metodo get o post
        headers: {
            'Content-Type': 'application/json' // specifico la uso
        },
        body: JSON.stringify({action: 'subjectTend'}) // encode
    })
        .then(response => response.json())
        .then(data => {
            displaySubjects = data;
            populateSelect(displaySubjects);
        })
        .catch(error => {
            console.error('Error:', error);
        });

}

function updateMoney(){
    if(dataTime['timeSpent']%300 ===0){
        dataTime['money'] += 20;
    }
}