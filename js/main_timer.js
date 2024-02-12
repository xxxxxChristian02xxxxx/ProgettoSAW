
//-------------------------FUNZIONE VEDERE SE LA MATERIA AGGIUNTA è VALIDA    -------------------------//
function isSubPresent(addSubject) {
    console.log(displaySubjects);
    for (i = 0; i < displaySubjects.length; i++){
        console.log("qua");
        if(addSubject ===displaySubjects[i]){
            return true;

        }
    }
    return false;

}
function blockSelection(){
    subChoosen.disabled =true;
}
function unlockSelection(){
    subChoosen.disabled =false;
}
//-------------------------FUNZIONE PER IL PER TIMER E STOPWATCH -------------------------//
function toggleButtonTS() {
    console.log(swipeCount);
    if ((swipeCount % 2 )=== 0) {
        displayTimer.classList.remove("hide");
        displayStopwatch.classList.add("hide");
        clocks['idTimerOrStopwatch'] = false;
    } else {
        displayStopwatch.classList.remove("hide");
        displayTimer.classList.add("hide");
        clocks['idTimerOrStopwatch'] =true;
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
function generatePopUp(popType,typeClock) {
    const popUp = document.getElementById('popUp');
    const popUpContent = document.getElementById('popUpContent');
    if (popUp && popUpContent) {
        switch (popType) {

            case 1:
                console.log("case 1");
                sessionPopUpAssembling(popUpContent,1);
                popUpContent.classList.add("open");//aggiungo il css
                sessionPopUpManager(popUpContent,typeClock);
                break;
            case 2:
                console.log("10")

                sessionPopUpAssembling(popUpContent,2);
                popUpContent.classList.add("open");//aggiungo il css
                breakPopUpManager(popUpContent,typeClock);
                break;
        }
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
function sessionPopUpManager(popUpContent,typeClock) {

    const descriptionArea=document.getElementById("area_descrizione");
    const wordCounter = document.getElementById("word counter");
    const limitWords =300;
    const closeButtonPopUp = document.getElementById("closePopUp");
    const cancelButtonPopUp = document.getElementById("cancelPopup")
    const textPopUp = document.getElementById("area_descrizione");
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
        isTimerDone =false;
        if(typeClock['idTimerEndOrStop']){
            resetClock(typeClock,descriptionArea);
        }
        textPopUp.value ="";
        textPopUp.placeholder ="scrivi qui ...";
        isTimerStarted=false;
        isStopawatchStarted=false;
       // rangeStart.classList.remove("rangePrevent");
        if(!typeClock['idTimerEndOrStop']){
            typeClock['startTimeTI'] =3;
            console.log("chiamo timer break ",typeClock['startTimeTI']);
            updateTimer(typeClock,typeClock['startTimeTI'])
            startClock(typeClock);
            if(startClock(typeClock)) {
                console.log("bloccato quq");

            }
        }

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
        popUpContent.classList.remove("open");
        console.log(typeClock);
        typeClock['idTimerEndOrStop'] =false;
        typeClock['idTimerOrStopwatch'] =false;

        generatePopUp(1,typeClock) ;
        unlockSelection();
        rangeStart.classList.remove("rangePrevent");
        console.log("bloccato qui");

    });

    break15minsButton.addEventListener('click', () => {
        popUpContent.classList.remove("open");
        clocks['startTimeTI'] =900;

        generatePopUp(1) ;
    });

    break30minsButton.addEventListener('click', () => {
        popUpContent.classList.remove("open");
        clocks['startTimeTI'] =1800;

        generatePopUp(1) ;
    });
}

//-------------------------FUNZIONE PER FARE L'UPDATE DEL TIMER -------------------------//
    function updateTimer(typeClock,timegone) {
            console.log(timegone);
            let hours = Math.floor(timegone / 3600);
            let remainingSeconds = timegone % 3600;
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
    function startClock(typeClock) {
        if(typeClock['idTimerOrStopwatch']) {    /*intervallo che deve essere aggiornato ogni 1000 ms*/
            console.log("dentro stopwatch secton");
            toggleButton('startStopwatch');
            interval = setInterval(() => {
                const currentTime = new Date();
                const diff = currentTime-time;
                const secondsPassed = Math.floor(diff / 1000);
                timeGone =typeClock['startTimeST']+secondsPassed;
                timmeSpentForSession++ ;
                timeSpentForMoney++
                updateTimer(typeClock,timeGone);

            }, 1000)
        }else{
            if(typeClock['idTimerEndOrStop']) {
                toggleButton('TimerStart');
                let timeGone=0;
                interval = setInterval(() => {
                    const currentTime = new Date();
                    const diff = currentTime - time;
                    const secondsPassed = Math.floor(diff / 1000);
                    timeGone = typeClock['startTimeTI'] - secondsPassed;
                    timmeSpentForSession++;
                    timeSpentForMoney++
                    updateTimer(typeClock);

                    if (timeGone=== 0) {
                        /*una vlta finito il timer pulisco l'intervallo*/
                        clearInterval(interval);
                        stopClock(typeClock);
                        generatePopUp(2,typeClock);
                        isTimerDone = true;
                        timeGone = typeClock['startTimeTI'];
                        updateTimer(typeClock,timeGone);
                    }
                }, 1000)
            }else{
                toggleButton('TimerStart');
                let timee = new Date().getTime();
                console.log("bho",typeClock['startTimeTI']);
                let timeGone = typeClock['startTimeTI'];
                if(timeGone>0){
                    interval = setInterval(() => {

                        const currentTime = new Date();
                        const diff = currentTime - timee;
                        const secondsPassed = Math.floor(diff / 1000);
                        timeGone = typeClock['startTimeTI'] - secondsPassed;
                        updateTimer(typeClock,timeGone);
                        if (timeGone === 0) {
                            /*una vlta finito il timer pulisco l'intervallo*/
                            clearInterval(interval);
                            // stopClock(typeClock);
                            typeClock['idTimerEndOrStop'] = true;
                            //updateTimer(typeClock,timeGone);
                            console.log("ultimo log");
                            return;
                        }
                    }, 1000)
                }


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
        dataTime['season'] = numberSeason;

        if(typeClock['idTimerOrStopwatch']){typeClock['timePassed'] =0;
        }else{typeClock['timePassed']=typeClock['startTimeTI'];}

        timmeSpentForSession = 0;
        updateTimer(typeClock);
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
        console.log("stopClock",typeClock);
        if(typeClock['idTimerOrStopwatch']){
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
            .then(response =>
                response.json())
            .then(data => {

            })
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
            .then(response =>
                 response.json()
                //console.log("Response: ", response); // log the response
               //return response.text();
            )
            .then(data => {
                displaySubjects = data;
                populateSelect(displaySubjects);
            })
            .catch(error => {
                console.error('Error:', error);
            });

    }

    function newSession(typeClock){
        console.log("newSession",typeClock);


        rangeStart.addEventListener("input",()=> {
            let timeOnClock = (7200 / rangeStart.max) * rangeStart.value;
            let hours = Math.floor(timeOnClock / 3600);
            var remainingSeconds = timeOnClock % 3600;
            let minutes = Math.floor(remainingSeconds / 60);
            let seconds = remainingSeconds % 60;
            if (hours) {
                formattedTime = `${hours.toString().padStart(2, "0")} : ${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
            } else {
                formattedTime = `${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
            }
            timeTimerElement.innerText = formattedTime;
            typeClock['startTimeTI'] = timeOnClock;
        })


        startTimerElement.addEventListener('click', function() {
            console.log("startTimerElement");
            subChoosen=document.getElementById("scelta");
            if(subChoosen.value !=='') {
                isTimerStarted = true;
                rangeStart.classList.add("rangePrevent");
                // Verifica lo stato del bottone
                if (buttonT.innerHTML === "Start") {
                    blockSelection();
                    // Prima volta che è stato cliccato
                    time = new Date().getTime();
                    startClock(typeClock);
                    // Aggiorna lo stato
                    buttonT.innerHTML = "Stop";
                    buttonT.setAttribute("aria-label", "Stop");
                } else {

                    // Seconda volta che è stato cliccato
                    stopClock(typeClock);
                    // Aggiorna lo stato
                    buttonT.innerHTML = "Start";
                    buttonT.removeAttribute("aria-label");
                }
            }else{
                alert("choose a subject to study first :)")
            }
        })
        resetTimerElement.addEventListener("click",()=> {
            console.log("resetTimer 2")
            if(isTimerStarted)  {
                {
                    stopClock(typeClock);
                    generatePopUp(1,typeClock);
                }
            }else
            {
                alert('Cannot reset without a start')
            }
        })

    }