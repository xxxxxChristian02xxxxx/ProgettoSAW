//-------------------------FUNZIONE PER POPOLARE IL MENU A TENDINA   -------------------------//
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

}
//-------------------------FUNZIONE VEDERE SE LA MATERIA AGGIUNTA è VALIDA    -------------------------//
function isSubPresent(addSubject){
    // esempio :
    for (let i = 0; i < displaySubjects.length; i++) {
        var subpr = displaySubjects[i].replace(/\s/g, '').toLowerCase();
        var subnew = addSubject.toString().replace(/\s/g, '').toLowerCase();
        console.log(subnew, ",", subpr);
        if (subnew === subpr) {
            console.log("sono qui");
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
        idTimerOrStopwatch = false;
    } else {
        displayStopwatch.classList.remove("hide");
        displayTimer.classList.add("hide");
        idTimerOrStopwatch=true;
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

function showStudySession(typeClock){
        console.log(timmeSpentForSession);
        timeDuratioSession.innerHTML = timmeSpentForSession + " secondi" ;
        moneyMoneyObtained.innerHTML = timeSpentForMoney;
        subSubStudied.innerHTML = subEventuallyStudied.value ;
}
//-------------------------FUNZIONE PER FARE L'UPDATE DEL TIMER -------------------------//
function updateTimer(typeClock) {
        let hours = Math.floor(timeGone / 3600);
        let remainingSeconds = timeGone % 3600;
        let minutes = Math.floor(remainingSeconds / 60);
        let seconds = remainingSeconds % 60;
        if (hours) {
            formattedTime = `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
        } else {
            formattedTime = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
        }
        if(typeClock){
            timeStopwatchElement.innerHTML = formattedTime;
        }else{
            timeTimerElement.innerHTML = formattedTime;
        }
}
//-------------------------FUNZIONE PER IL INZIARE E STOPPARE IL TIMER IL TIMER -------------------------//
function startClock(typeClock) {
    if(typeClock) {    /*intervallo che deve essere aggiornato ogni 1000 ms*/
        console.log("dentro stopwatch secton");
        toggleButton('startStopwatch');
        interval = setInterval(() => {
            const currentTime = new Date();
            const diff = currentTime-time;
            const secondsPassed = Math.floor(diff / 1000);
            timeGone =startTimeST+secondsPassed;
            console.log(timeGone, secondsPassed, startTimeST, diff, time );
            timmeSpentForSession++ ;
            timeSpentForMoney++
            updateTimer(idTimerOrStopwatch);

        }, 1000)
    }else{
        toggleButton('TimerStart');
        console.log("inizio setinterval");
        interval = setInterval(() => {
            const currentTime = new Date();
            const diff = currentTime-time;
            const secondsPassed = Math.floor(diff / 1000);
            timeGone = startTimeTI-secondsPassed;
            timmeSpentForSession++;
            timeSpentForMoney++
            updateTimer(idTimerOrStopwatch);

            if (timeGone === 0) {
                /*una vlta finito il timer pulisco l'intervallo*/
                clearInterval(interval);
                showStudySession();
                stopClock();
                isTimerDone=true;
                popUp.classList.add("open");//aggiungo il css
                timeGone = startTimeTI;
                updateTimer(typeClock);
            }
        }, 1000)
    }
}
//-------------------------FUNZIONE PER IL RESETTARE IL TIMER -------------------------//
function resetClock(typeClock) {
    clearInterval(interval);
    showStudySession(typeClock);

    operationType=1;
    dataTime['typeSession'] =idTimerOrStopwatch;
    dataTime['timeSpent'] = timmeSpentForSession;
    dataTime['money'] =timeSpentForMoney;
    dataTime['subjectName'] = subEventuallyStudied.value;
    dataTime['description'] = descriptionArea.value;
    // Ho dovuto cambiare il db mettendo che può accettare valori nulli
    dataTime['season'] = numberSeason;


    if(typeClock)
    {
        timeGone =0;
    }
    else{
        timeGone=startTimeTI;
    }
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
    console.log("stopTimer", typeClock);
    if(typeClock){
        toggleButton('startStopwatch');

    }else{
        toggleButton('TimerStart');
    }
}
function databaseDelivery(json_data,operationType) {
    console.log('json_data in delivery: ', json_data);
    console.log(operationType);
    json_data['typeSession'] = operationType;
    console.log(json_data);
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