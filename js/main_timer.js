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
function toggleButtonTS(buttonId) {
    if ((swipeCount % 2 )=== 0) {
        displayTimer.classList.remove("hide");
        displayStopwatch.classList.add("hide");
        idTimerOrStopwatch = true;
    } else {
        displayStopwatch.classList.remove("hide");
        displayTimer.classList.add("hide");
        idTimerOrStopwatch=false;
    }
}

//-------------------------FUNZIONE PER IL TOGGLE TASTO START -------------------------//
function toggleButton(buttonId){
    // Riferimento all'elemento del bottone
    var button = document.getElementById(buttonId);
    if(button.innerHTML !== "Start"){
        button.innerHTML = "Stop";
        // Impostazione attributo per cambiare colore bottone
        button.setAttribute("aria-label", "Stop");
    }
    else{
        button.innerHTML = "Start";
        button.removeAttribute("aria-label");
    }
    console.log(counting);
}
//-------------------------FUNZIONE PER IL TOGGLE -------------------------//
function showStudySession(){
    console.log(subSubStudied);
    timeDuratioSession.innerHTML=  timmeSpentForSession;
    moneyMoneyObtained.innerHTML =timeSpentForMoney;
    subSubStudied.innerHTML = subEventuallyStudied.value;

}
//-------------------------FUNZIONE PER FARE L'UPDATE DEL TIMER -------------------------//
function updateTimer() {

    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;
    /*  funzione per stampare a schermo il tempo che scorre ,padStart serve per stampare 0, col lo 0 davanti con 2 -> voglio 2 digit e se non ho nulla metto "0" di default*/
    formattedTime = `${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
    timeElement.innerHTML = formattedTime;
    timmeSpentForSession ++;

}
//-------------------------FUNZIONE PER IL INZIARE E STOPPARE IL TIMER IL TIMER -------------------------//
function startTimer() {

    /*intervallo che deve essere aggiornato ogni 1000 ms*/
    toggleButton('Timer');
    interval = setInterval(() => {
        timeLeft--;
        timeSpentForMoney++
        updateTimer();
        if (timeLeft === 0) {
            /*una vlta finito il timer pulisco l'intervallo*/
            clearInterval(interval);
            alert("finito");
            timeLeft = 1500 ;
            updateTimer();
        }
    }, 1000)
}
//-------------------------FUNZIONE PER IL RESETTARE IL TIMER -------------------------//
function resetTimer() {
    console.log("resetTimer")
    clearInterval(interval);

    timeLeft = 1500;
    showStudySession();
    updateTimer();
    console.log("mando al back");
    const dataTime={
        typeSession:idTimerOrStopwatch,
        timeSpent :timmeSpentForSession,
        money : timeSpentForMoney,
        subjactName: subEventuallyStudied.value,
        description:null,
        season:null
    }
    console.log("json: ",dataTime);

    databaseDelivery(dataTime);

}
//-------------------------FUNZIONE PER FERMARE IL TIMER  -------------------------//
function stopTimer() {
    clearInterval(interval);
    toggleButton('Timer');
    console.log(startTime, formattedTime);
}

function databaseDelivery(dataTime){
    console.log("entratat nella funzione");

    fetch('../backend/main_backend.php', { // dico il percorso del file di back end
        method: 'POST', //metodo get o post
        headers: {
            'Content-Type': 'application/json' // specifico la uso
        },
        body: JSON.stringify(dataTime) // encode
    })
        .then(response => response.json()) //prendo la risposta di login backend(ha ottenuto i risultati delle query ) e li ha messi nella variabile

        .then(data => { //prendo i dati ottenuti e li processo

            if (data.success) {
                window.location.href = '../main.php'; // se chiamata è andata bene faccio display del main.php
            } else {
                window.alert('something has failed'); //altimenti mando messaggio di errore
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

}