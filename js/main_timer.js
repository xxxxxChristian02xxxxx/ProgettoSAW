
//-------------------------FUNZIONE PER IL TOGGLE -------------------------//
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
        moneyMoneyObtained.innerHTML =timeSpentForMoney;
        timeDuratioSession.innerHTML=  formattedTime;
        subSubStudied.innerHTML = null;

    }
    //-------------------------FUNZIONE PER FARE L'UPDATE DEL TIMER -------------------------//
    function updateTimer() {
        let minutes = Math.floor(timeLeft / 60);
        let seconds = timeLeft % 60;
        /*  funzione per stampare a schermo il tempo che scorre ,padStart serve per stampare 0, col lo 0 davanti con 2 -> voglio 2 digit e se non ho nulla metto "0" di default*/
        formattedTime = `${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
        timeElement.innerHTML = formattedTime;


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
            timeLeft = 1500;
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
        databaseDelivery(dataTime);

    }
    //-------------------------FUNZIONE PER FERMARE IL TIMER  -------------------------//
    function stopTimer() {
        clearInterval(interval);
        toggleButton('Timer');
        console.log(startTime, formattedTime);
    }

function databaseDelivery(dataTime){


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