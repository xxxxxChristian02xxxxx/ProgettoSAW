function isSubPresent(addSubject, subChoosen) {
    const options = subChoosen.options;
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
function toggleButton(buttonId) {
    var button = document.getElementById(buttonId);
    if (button.innerHTML !== 'Start') {
        button.innerHTML = "Stop";
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
        timeDuratioSession.innerHTML = dataTime['timeSpent'] + "s ";
    }else if(dataTime['timeSpent']>60 && dataTime['timeSpent']< 3600){
        timeDuratioSession.innerHTML  = Math.floor(dataTime['timeSpent'] / 60) + "m " ;
    }else{
        timeDuratioSession.innerHTML = Math.floor(dataTime['timeSpent'] / 3600) + "h " + Math.floor((dataTime['timeSpent'] % 3600) / 60) + "m";
    }
    moneyMoneyObtained.innerHTML = dataTime['money'];
    subSubStudied.innerHTML = subChoosen.value;
}
function populateSelect(options) {
    let subEventuallyStudied = document.getElementById("scelta");
    options.forEach(op => {
        subEventuallyStudied.appendChild(generateOptions(op['NAME']));
    })
}
function generateOptions(option) {
    let optionElement = document.createElement("option");
    optionElement.value = option;
    optionElement.textContent = option;
    return optionElement;
}
function updateTimer(typeClock, timeGone) {
    let timeTimerElement = document.getElementById("timeTimer");
    let timeStopwatchElement = document.getElementById("timeStopwatch");
    let formattedTime;
    let hours = Math.floor(timeGone / 3600);
    let remainingSeconds = timeGone % 3600;
    let minutes = Math.floor(remainingSeconds / 60);
    let seconds = remainingSeconds % 60;

    if (hours) {
        formattedTime = `${hours.toString().padStart(2, "0")} : ${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
    } else {
        formattedTime = `${minutes.toString().padStart(2, "0")} : ${seconds.toString().padStart(2, "0")}`;
    }
    if (typeClock['idTimerOrStopwatch']) {
        timeStopwatchElement.innerHTML = formattedTime;
    } else {
        timeTimerElement.innerHTML = formattedTime;
    }

}
function startClock(typeClock, time, timeBreakStart) {
    if (typeClock['idTimerOrStopwatch']) {    /*intervallo che deve essere aggiornato ogni 1000 ms*/
        toggleButton('startStopwatch');

        typeClock['interval'] = setInterval(() => {
            const currentTime = new Date();
            const diff = currentTime - time;
            const secondsPassed = Math.floor(diff / 1000);
            typeClock['timegone'] = typeClock['modifiableTimeStopwatch'] + secondsPassed;
            dataTime['timeSpent']++;
            updateMoney();
            updateTimer(typeClock,  typeClock['timegone']);

        }, 1000)
    } else {
        if (!typeClock['idTimerEndOrStop']) {
            toggleButton('TimerStart');
            typeClock['interval'] = setInterval(() => {
                const currentTime = new Date();
                const diff = currentTime - time;
                const secondsPassed = Math.floor(diff / 1000);
                typeClock['timegone'] = typeClock['modifiableTimeTimer'] - secondsPassed;
                dataTime['timeSpent']++;
                updateTimer(typeClock,  typeClock['timegone']);
                updateMoney();
                if ( typeClock['timegone'] === 0) {
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
            updateTimer(typeClock, timeBreakStart);
            typeClock['interval'] = setInterval(() => {
                const currentTime = new Date();
                const diff = currentTime - time;
                const secondsPassed = Math.floor(diff / 1000);
                typeClock['timegone'] = timeBreakStart - secondsPassed;
                updateTimer(typeClock,  typeClock['timegone']);
                if ( typeClock['timegone'] === 0) {
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
function resetClock(typeClock,option) {
    clearInterval(typeClock['interval']);
    if(option==="timerStop"){
        var subEventuallyStudied = document.getElementById("scelta");
        dataTime['typeSession'] = typeClock['idTimerOrStopwatch'];
        dataTime['subjectName'] = subEventuallyStudied.value;
        databaseDelivery(dataTime, 1);
    }
    if (typeClock['idTimerOrStopwatch']) {
        typeClock['timegone'] = typeClock['startTimeST'];
        typeClock['modifiableTimeStopwatch'] =typeClock['startTimeST'];

    } else {
        typeClock['timegone'] = typeClock['startTimeTI'];
        typeClock['modifiableTimeTimer'] =typeClock['startTimeTI'];

    }
    dataTime['timeSpent'] = 0;
    updateTimer(typeClock, typeClock['timegone']);
    dataTime['money'] = 0;
    var range = document.getElementById("TimerRange");
    range.classList.remove("rangePrevent");

}
function stopClock(typeClock) {
    clearInterval(typeClock['interval']);
    if (typeClock['idTimerEndOrStop']) {
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
        .then(response=>{
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) { // No content
                return null;
            }
            console.log(response.text())
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
        body: JSON.stringify({action: 'subjectTend'}) // encode
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) { // No content
                return null;
            }
            return response.json();
        })
        .then(data => {
            populateSelect(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });

}
function updateMoney(){
    if(dataTime['timeSpent']%30 ===0 && dataTime['timeSpent']!==0){
        dataTime['money'] += 20;
    }
}
function overWrite(typeClocks){
    if(!typeClocks['idTimerOrStopwatch']) {
        typeClocks['modifiableTimeTimer'] = typeClocks['timegone'];
    }else{
        typeClocks['modifiableTimeStopwatch'] = typeClocks['timegone'];
    }

}