//-------------------------FUNZIONE PER POPOLARE IL MENU A TENDINA   -------------------------//
/*
function populateSelect(options) {
    console.log(options);
    subChoosen.innerHTML = "";
    subChoosen.innerHTML = "<div><select><option value=''> </option></select> <span> <button> - </button ></span></div>";
    options.forEach(option => {
        var optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.textContent = option;
        subChoosen.appendChild(optionElement);
    });
    subEventuallyStudied.addEventListener('click', function() {
        subEventuallyStudied = document.getElementById("scelta").value;
    });

}*/
//-------------------------FUNZIONE VEDERE SE LA MATERIA AGGIUNTA è VALIDA    -------------------------//
function isSubPresent(addSubject){
    // esempio :
    for (let i = 0; i < displaySubjects.length; i++) {
        var subpr = displaySubjects[i].replace(/\s/g, '').toLowerCase();
        var subnew = addSubject.toString().replace(/\s/g, '').toLowerCase();
        console.log(subnew, ",", subpr);
        if (subnew === subpr) {
            console.log("sono qui");
            return false;
        }
    }
    return true;
}
function blockSelection(){
    subChoosen.disabled =true;
}
function unlockSelection(){
    subChoosen.disabled =false;
}
//-------------------------FUNZIONE PER IL PER TIMER E STOPWATCH -------------------------//
function toggleButtonTS(typeClock,displayTimer,displayStopwatch,swipeCount){

    console.log(swipeCount);
    if ((swipeCount % 2 )=== 0) {
        displayTimer.classList.remove("hide");
        displayStopwatch.classList.add("hide");
        typeClock['idTimerOrStopwatch'] = false;
    } else {
        displayStopwatch.classList.remove("hide");
        displayTimer.classList.add("hide");
        typeClock['idTimerOrStopwatch']=true;
    }
}
//-------------------------FUNZIONE PER IL TOGGLE TASTO START -------------------------//
function toggleButton(buttonId){
    // Riferimento all'elemento del bottone
    var button = document.getElementById(buttonId);
    console.log("button");
    if(button.innerHTML !== 'Start'){
        button.innerHTML = "Stop";
        // Impostazione attributo per cambiare colore bottone
        button.setAttribute("aria-label", "Stop");
    }
    else{
        button.innerHTML = "Start";
        button.removeAttribute("aria-label");
    }
}

//-------------------------FUNZIONE POPUP -------------------------//
function showStudySession(){
    var timeDuratioSession =document.getElementById("timeDuration");
    var subSubStudied = document.getElementById("subStudied"); //materia nel popup
    var moneyMoneyObtained= document.getElementById("moneyGotten")

    console.log(timmeSpentForSession);
    timeDuratioSession.innerHTML = timmeSpentForSession + " secondi" ;
    moneyMoneyObtained.innerHTML = timeSpentForMoney;
    subSubStudied.innerHTML = subEventuallyStudied.value ;
}
function populateSelect(options){
    let gridHtml = '';
    let subEventuallyStudied=document.getElementById("scelta");
    options.forEach(op =>{
        gridHtml += generateOptions(op);
    })
    subEventuallyStudied.innerHTML = gridHtml;

}
function generateOptions(options){
    return `<div>
                <select>
                    <option value=''> ${options}</option>
                </select> 
           </div> `
}
function generatePopUp(popType,typeClock,timeBreak) {
    const popUp = document.getElementById('popUp');
    const popUpContent = document.getElementById('popUpContent');
    if (popUp && popUpContent) {
        switch (popType) {

            case 1:
                console.log("case 1");
                sessionPopUpAssembling(popUpContent,1);
                popUpContent.classList.add("open");//aggiungo il css
                sessionPopUpManager(popUpContent,typeClock,timeBreak);
                break;
            case 2:
                console.log("10")

                sessionPopUpAssembling(popUpContent,2);
                popUpContent.classList.add("open");//aggiungo il css
                breakPopUpManager(popUpContent,typeClock);
                break;
        }
    }else{
        console.log("nope");
    }
}
function sessionPopUpAssembling(popUpContent,typePopUp) {
    let gridHtml = '';
    if(typePopUp ===1) {
        gridHtml += generatePopUpSession();
    }else if(typePopUp ===2){
        gridHtml += generatePopUpBreak();

    }
    popUpContent.innerHTML = gridHtml;
}
function generatePopUpSession() {

    return `
<div class="popup-inner">
        <h2> Your Statistics </h2>
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
`;

}
function sessionPopUpManager(popUpContent,typeClock,timeBreakStart) {
    unlockSelection();

    const descriptionArea=document.getElementById("area_descrizione");
    const wordCounter = document.getElementById("word counter");
    const limitWords =300;
    const closeButtonPopUp = document.getElementById("closePopUp");
    const cancelButtonPopUp = document.getElementById("cancelPopup")
    const textPopUp = document.getElementById("area_descrizione");
    var buttonT = document.getElementById("TimerStart");
    var buttonS = document.getElementById("startStopwatch");

    console.log("sessionPopUpManager",typeClock);

    showStudySession()
    closeButtonPopUp.addEventListener("click",()=>{
        popUpContent.classList.remove("open");//aggiungo il css
        if(buttonT.innerHTML==="Stop"){
            buttonT.innerHTML = "Start";
            buttonT.removeAttribute("aria-label");
        }
        if(buttonS.innerHTML==="Stop"){
            buttonS.innerHTML = "Start";
            buttonS.removeAttribute("aria-label");
        }
        resetClock(typeClock,descriptionArea);
        textPopUp.value ="";
        textPopUp.placeholder ="scrivi qui ...";
        isTimerStarted=false;
        isStopawatchStarted=false;
        console.log("yuu", isTimerDone)
        // rangeStart.classList.remove("rangePrevent");
        if(typeClock['idTimerEndOrStop'] ){
            console.log("hrei");
            let timeBreak = new Date().getTime();
            startClock(typeClock,timeBreak,timeBreakStart);
        }

    })
    //-------------------------EVENTO PER DIRE CHIUDERE IL POPUP CONTINUANDO -------------------------//
    cancelButtonPopUp.addEventListener("click",()=>{
        if(!typeClock['idTimerEndOrStop']) {
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
function generatePopUpBreak(){
    return` <div id="breakTime">
            <h2>Break Time</h2>
            <p>You have accomplished your goal, take some rest.</p>
            <p>Choose how long is your break:</p>
            <button id="break5mins">5 mins</button>
            <button id="break15mins">15 mins</button>
            <button id="break30mins">30 mins</button>
        </div>`
}
function breakPopUpManager(popUpContent,typeClock){

    const break5minsButton = document.getElementById('break5mins');
    const break15minsButton = document.getElementById('break15mins');
    const break30minsButton = document.getElementById('break30mins');

    break5minsButton.addEventListener('click', () => {
        // handle 5 mins break
        let timeBreakStart=3;
        typeClock['idTimerOrStopwatch'] =false;
        popUpContent.classList.remove("open");
        generatePopUp(1,typeClock,timeBreakStart) ;
        unlockSelection();
        //rangeStart.classList.remove("rangePrevent");
    });

    break15minsButton.addEventListener('click', () => {
        let timeBreakStart=5;
        typeClock['idTimerOrStopwatch'] =false;
        popUpContent.classList.remove("open");
        generatePopUp(1,typeClock,timeBreakStart) ;
        unlockSelection();
        //rangeStart.classList.remove("rangePrevent");
    });

    break30minsButton.addEventListener('click', () => {
        let timeBreakStart=10;
        typeClock['idTimerOrStopwatch'] =false;
        popUpContent.classList.remove("open");
        generatePopUp(1,typeClock,timeBreakStart) ;
        unlockSelection();
        //rangeStart.classList.remove("rangePrevent");
    });
}
//-------------------------FUNZIONE PER FARE L'UPDATE DEL TIMER -------------------------//
function updateTimer(typeClock,timeGone) {
    let timeTimerElement = document.getElementById("timeTimer");
    let timeStopwatchElement = document.getElementById("timeStopwatch");
    let formattedTime;
    let hours = Math.floor(timeGone / 3600);
    let remainingSeconds = timeGone % 3600;
    let minutes = Math.floor(remainingSeconds / 60);
    let seconds = remainingSeconds % 60;

    if(hours){
        formattedTime = `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
    } else {
        formattedTime = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
    }
    if(typeClock['idTimerOrStopwatch']){
        timeStopwatchElement.innerHTML = formattedTime;
    }else{
        timeTimerElement.innerHTML = formattedTime;
    }
}
//-------------------------FUNZIONE PER IL INZIARE E STOPPARE IL TIMER IL TIMER -------------------------//
function startClock(typeClock,time,timeBreakStart) {
    console.log(typeClock['idTimerOrStopwatch'], "false timer, true stopwatch")
    var timeGone =0 ;

    if(typeClock['idTimerOrStopwatch']) {    /*intervallo che deve essere aggiornato ogni 1000 ms*/
        console.log("dentro stopwatch secton", time );
        toggleButton('startStopwatch');

        interval = setInterval(() => {
            const currentTime = new Date();
            const diff = currentTime-time;
            const secondsPassed = Math.floor(diff / 1000);
            timeGone =typeClock['startTimeST'] +secondsPassed;
            console.log(timeGone, secondsPassed, typeClock['startTimeST'], diff, time );
            timmeSpentForSession++ ;
            timeSpentForMoney++
            updateTimer(typeClock,timeGone);

        }, 1000)
    }else{
        if(!typeClock['idTimerEndOrStop']){
            toggleButton('TimerStart');
            console.log("inizio setinterval");

            interval = setInterval(() => {
                const currentTime = new Date();
                const diff = currentTime-time;
                const secondsPassed = Math.floor(diff / 1000);
                timeGone =typeClock['startTimeTI'] -secondsPassed;
                timmeSpentForSession++;
                timeSpentForMoney++
                console.log("timeGone",timeGone,typeClock['startTimeTI'] ,secondsPassed);
                updateTimer(typeClock,timeGone);

                if (timeGone === 0) {
                    /*una vlta finito il timer pulisco l'intervallo*/
                    clearInterval(interval);
                    stopClock(typeClock);
                    typeClock['idTimerEndOrStop']=true;
                    generatePopUp(2,typeClock);


                }
            }, 1000)
        }else  {

            typeClock['idTimerEndOrStop']=false;
            toggleButton('TimerStart');
            console.log("inizio TimerBreakStart", time );
            let timeGone=0;
            updateTimer(typeClock,timeBreakStart);
            interval = setInterval(() => {
                const currentTime = new Date();
                const diff = currentTime-time;
                const secondsPassed = Math.floor(diff / 1000);
                timeGone = timeBreakStart-secondsPassed;
                updateTimer(typeClock,timeGone);
                console.log("till now",timeGone,timeBreakStart,secondsPassed)
                if (timeGone === 0) {
                    console.log("fine break ");
                    /*una vlta finito il timer pulisco l'intervallo*/
                    clearInterval(interval);
                }
            }, 1000)
        }
    }
}
//-------------------------FUNZIONE PER IL RESETTARE IL TIMER -------------------------//
function resetClock(typeClock,descriptionArea) {
    clearInterval(interval);

    showStudySession(typeClock);

    operationType=1;
    dataTime['typeSession'] =typeClock['idTimerOrStopwatch'];
    dataTime['timeSpent'] = timmeSpentForSession;
    dataTime['money'] =timeSpentForMoney;
    dataTime['subjectName'] = subEventuallyStudied.value;
    dataTime['description'] = descriptionArea.value;
  //  dataTime['season'] = numberSeason;

    let timeGone;
    if(typeClock['idTimerOrStopwatch']){timeGone =0;
    }else{timeGone=typeClock['startTimeTI'];}
    timmeSpentForSession = 0;
    updateTimer(typeClock,timeGone);
    timeSpentForMoney=0;
    databaseDelivery(dataTime,operationType);

}
function jsonClear(json){
    for (let key in json) {
        // Set the value of the current key to null
        json[key] = null;
    }

}
//-------------------------FUNZIONE PER FERMARE IL TIMER  -------------------------//
function stopClock(typeClock) {
    clearInterval(interval);
    console.log("stopTimer", typeClock);
    if(typeClock){
        toggleButton('startStopwatch');

    }else{
        toggleButton('TimerStart');
    }
}
function databaseDelivery(json_data,operationType) {
    console.log('json_data in delivery: ', json_data);
    let Action;
    switch (operationType){
        case 1:
            Action='addSessionStudied';
            break;
        case 2:
            Action='updateSubject';
            break;

    }
    fetch('../backend/be_main.php', { // dico il percorso del file di back end
        method: 'POST', //metodo get o post
        headers: {
            'Content-Type': 'application/json' // specifico la uso
        },
        body: JSON.stringify({json_data, action:Action}  ) // encode
    })

        .then(response => console.log(response))
        .catch(error => {
            console.error('Error:', error);
        });

}
function subjectsRequests() {
    fetch('../backend/be_main.php', { // dico il percorso del file di back end
        method: 'POST', //metodo get o post
        headers: {
            'Content-Type': 'application/json' // specifico la uso
        },
        body: JSON.stringify({action: 'subjectTend' }) // encode
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