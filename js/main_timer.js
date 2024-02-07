//-------------------------FUNZIONE PER POPOLARE IL MENU A TENDINA   -------------------------//
function populateSelect(options) {
    subChoosen.innerHTML = "";
    subChoosen.innerHTML = "<div><option value=''> </option> <span> <button> - </button ></span></div>";
    options.forEach(option => {
        var optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.textContent = option;
        subChoosen.appendChild(optionElement);
    });

}
//-------------------------FUNZIONE VEDERE SE LA MATERIA AGGIUNTA è VALIDA    -------------------------//
function isSubPresent(addSubject){
    console.log(displaySubjects);
    // esempio :
    // sub.replace(/\s/g, '').toLowerCase() =>tolgo gli spazi e metto no case sensitive
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

}
function unlockSelection(){

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
//-------------------------FUNZIONE PER IL TOGGLE -------------------------//
function showStudySession(typeClock){
        console.log(timmeSpentForSession);
        timeDuratioSession.innerHTML = timmeSpentForSession + " secondi" ;
        moneyMoneyObtained.innerHTML = timeSpentForMoney;
        subSubStudied.innerHTML = subEventuallyStudied.value ;
}
//-------------------------FUNZIONE PER FARE L'UPDATE DEL TIMER -------------------------//
function updateTimer(typeClock) {



    if(typeClock){

        let minutes = Math.floor(timmeSpentForSession / 60);
        let seconds = timmeSpentForSession % 60;
        /*  funzione per stampare a schermo il tempo che scorre ,padStart serve per stampare 0, col lo 0 davanti con 2 -> voglio 2 digit e se non ho nulla metto "0" di default*/
        formattedTime = `${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
        timeStopwatchElement.innerHTML = formattedTime;
    }else{
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        /*  funzione per stampare a schermo il tempo che scorre ,padStart serve per stampare 0, col lo 0 davanti con 2 -> voglio 2 digit e se non ho nulla metto "0" di default*/
        formattedTime = `${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
        timeTimerElement.innerHTML = formattedTime;

    }
   // timmeSpentForSession ++;

}
//-------------------------FUNZIONE PER IL INZIARE E STOPPARE IL TIMER IL TIMER -------------------------//
function startTimer(typeClock) {
    if(typeClock) {    /*intervallo che deve essere aggiornato ogni 1000 ms*/
        console.log("dentro stopwatch secton");
        toggleButton('startStopwatch');
        interval = setInterval(() => {
            timeLeft++;
            timmeSpentForSession++;
            timeSpentForMoney++
            updateTimer(typeClock);
        }, 1000)
    }else{
        toggleButton('TimerStart');
        console.log("inizio setinterval");
        interval = setInterval(() => {
            timeLeft--;
            timmeSpentForSession++;
            timeSpentForMoney++
            updateTimer();
            if (timeLeft === 0) {
                /*una vlta finito il timer pulisco l'intervallo*/
                clearInterval(interval);
                alert("finito");
                timeLeft = 1500;
                updateTimer(typeClock);
            }
            console.log("tempo ora :",timmeSpentForSession)
        }, 1000)
    }
}
//-------------------------FUNZIONE PER IL RESETTARE IL TIMER -------------------------//
function resetTimer(typeClock) {
    clearInterval(interval);

    showStudySession(typeClock);

    const dataTime={
        typeSession:idTimerOrStopwatch,
        timeSpent:timmeSpentForSession,
        money:timeSpentForMoney,
        subjectName: subEventuallyStudied.value,
        description:descriptionArea.value,
        season:1
    }

    //console.log("json: ", dataTime);
    timeLeft=1500;
    timmeSpentForSession = 0;
    updateTimer(typeClock);
    //jsonClear(dataTime)
    //timeDuratioSession=0;
    timeSpentForMoney=0;


    //console.log("json: ",dataTime);
    databaseDelivery(dataTime);

}
function jsonClear(json){
    for (let key in json) {
        // Set the value of the current key to null
        json[key] = null;
    }

}


//-------------------------FUNZIONE PER FERMARE IL TIMER  -------------------------//
function stopTimer(typeClock) {
    clearInterval(interval);
    console.log("stopTimer", typeClock);
    if(typeClock){
        toggleButton('startStopwatch');

    }else{
        toggleButton('TimerStart');
    }
    console.log(startTime, formattedTime);
}

function databaseDelivery(json_data) {
    console.log('json_data in delivery: ', json_data);

    fetch('../backend/main_backend.php', { // dico il percorso del file di back end
        method: 'POST', //metodo get o post
        headers: {
            'Content-Type': 'application/json' // specifico la uso
        },
        body: JSON.stringify(json_data) // encode
    })

        .then(response => console.log(response))
    .catch(error => {
        console.error('Error:', error);
    });

}
function subjectsRequests() {

    fetch('../backend/main_backend.php', { // dico il percorso del file di back end
    })

        .then(response => console.log(response))
        .then(data => {
            displaySubjects = data['subjects'];
        })
        .catch(error => {
            console.error('Error:', error);
        });

}