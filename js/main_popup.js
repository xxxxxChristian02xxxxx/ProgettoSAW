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
                        <p id="timeDuration" >Tempo</p>
                    </div>
                    <div>
                        <p id="materia_studiata"  class="dataText">Subjects studied:</p>
                        <p id="subStudied"></p>
                    </div>
                    <div>
                        <p id="soldi_ottenuti" class="dataText">Money earned:</p>
                        <p id="moneyGotten" >Soldi</p>
                    </div>
            
                    <div id="descrizione" class ="description">
                        <div>
                            <textarea id ="area_descrizione" rows="4" cols="50" placeholder="Add a short description..."></textarea>
                            <p id ="word counter" > 0/300</p>
                        </div>
                    </div>
                </div>
                <div class="buttonsPopup">
                    <span > <button  class="popup_button_left" id="closePopUp" > Yes </button> </span>
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
            popUpContent.classList.remove("open");
            overWrite(typeClock);
        }
    })
    //-------------------------EVENTO CONTARE NUMERO CARATTERI NELLA SEZIONE DESCRIZIONE  -------------------------//
    descriptionArea.addEventListener("keydown", function (e) {
        const text = descriptionArea.value;

        if (text.length >= limitWords && e.key !== 'Backspace' && e.key !== 'Delete') {
            e.preventDefault();
        }
    });
    descriptionArea.addEventListener("paste", function (e) {
        const text = e.clipboardData.getData('text/plain');
        if ((descriptionArea.value.length + text.length) > limitWords) {
            e.preventDefault();
        }
    });
    descriptionArea.addEventListener("input", function (e) {
        const text = descriptionArea.value;
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
    </div>`
}
function breakPopUpManager(popUpContent, typeClock) {

    const break5minsButton = document.getElementById('break5mins');
    const break15minsButton = document.getElementById('break15mins');
    const break30minsButton = document.getElementById('break30mins');

    break15minsButton.style.display="none";
    break30minsButton.style.display="none";
    if ((typeClock['timeSpent'] >= 1800) && (typeClock['timeSpent'] < 3600)) {
        break15minsButton.removeAttribute("style");
    } else if (typeClock['timeSpent'] >= 3600) {
        break30minsButton.removeAttribute("style");
        break15minsButton.removeAttribute("style");
    }
    break5minsButton.addEventListener('click', () => {
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