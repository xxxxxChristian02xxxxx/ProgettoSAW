const dataTime={    //per db
    typeSession: null,
    timeSpent: null,
    money : 0,
    subjectName: null,
    description: null,

    // season: null,

};

function swipe(clocks){
    const swipeLeft = document.getElementById("buttom-Swipe-left");
    const swipeRight = document.getElementById("buttom-Swipe-right");
    var displayTimer = document.getElementById("containertimer");
    var displayStopwatch = document.getElementById("constainerstopwatch");
    var swipeCount =0; // for < > button
    displayStopwatch.classList.add("hide");
    swipeLeft.addEventListener("click", ()=>{
        if(!clocks['isTimerStarted'] && !clocks['isStopawatchStarted'])  {
            swipeCount++;
            toggleButtonTS(clocks,displayTimer,displayStopwatch,swipeCount);
        }

    })
    swipeRight.addEventListener("click", ()=>{
        if(!clocks['isTimerStarted'] && !clocks['isStopawatchStarted']) {
            swipeCount++;
            toggleButtonTS(clocks,displayTimer,displayStopwatch,swipeCount);
        }
    })
}
function sessionTimer(clocks){
    //gestione timer
    const startTimerElement= document.getElementById("TimerStart");
    const resetTimerElement= document.getElementById("resetTimer");
    const timeTimerElement= document.getElementById("timeTimer");
    var buttonT = document.getElementById("TimerStart");
    const rangeStart =document.getElementById("TimerRange");
    rangeStart.value = 5;
    rangeStart.min = 1;
    rangeStart.max = 24;
    clocks['modifiableTimeTimer']=clocks['startTimeTI'];
    updateTimer(clocks,clocks['modifiableTimeTimer'])
    rangeStart.value = (clocks['modifiableTimeTimer'] * rangeStart.max)/ 7200 ;
    rangeStart.addEventListener("input",()=> {
        let formattedTime
        let timeOnClock= (7200 / rangeStart.max) * rangeStart.value;
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
        clocks['modifiableTimeTimer']=timeOnClock;
        clocks['startTimeTI']=timeOnClock;
    })
    startTimerElement.addEventListener('click', function() {
        var subChoosen=document.getElementById("scelta").value;
        rangeStart.classList.add("rangePrevent");
        if(subChoosen !=='') {
            clocks['isTimerStarted'] = true;
            // Verifica lo stato del bottone
            if (buttonT.innerHTML === "Start") {
                blockSelection();
                // Prima volta che è stato cliccato
                console.log('Primo clic');
                console.log("ora",clocks['modifiableTimeTimer'])
                var time = new Date().getTime();
                console.log(clocks,time,null);

                startClock(clocks,time,null);
                // Aggiorna lo stato
                buttonT.innerHTML = "Stop";
                buttonT.setAttribute("aria-label", "Stop");
            } else {

                // Seconda volta che è stato cliccato
                console.log('Secondo clic');
                console.log(clocks);
                overWrite(clocks);
                console.log("trascrivi",clocks);
                stopClock(clocks);
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
        if(clocks['isTimerStarted'])  {
            {

                stopClock(clocks);
                generatePopUp(1,clocks);

            }
        }else
        {
            alert('Cannot reset without a start')
        }
    })

}
function sessionStopwatch(clocks){
    const startStopwatchElement= document.getElementById("startStopwatch");
    const resetStopwatchElement= document.getElementById("resetStopwatch");
    var  subEventuallyStudied=document.getElementById("scelta");
    var buttonS = document.getElementById("startStopwatch");
    clocks['modifiableTimeStopwatch']=clocks['startTimeST'];

    startStopwatchElement.addEventListener('click', function() {
        if(subEventuallyStudied.value !=='') {
            clocks['isStopawatchStarted'] = true;
            // Verifica lo stato del bottone
            if (buttonS.innerHTML === "Start") {
                blockSelection();
                // Prima volta che è stato cliccato
                console.log('Primo clic');
                var time = new Date().getTime();
                console.log("ora2",clocks['modifiableTimeStopwatch'])

                startClock(clocks,time,null);
                // Aggiorna lo stato
                buttonS.innerHTML = "Stop";
                buttonS.setAttribute("aria-label", "Stop");
            } else {

                // Seconda volta che è stato cliccato
                console.log('Secondo clic');
                overWrite(clocks)
                console.log("trascritto",clocks)

                stopClock(clocks);
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
        if(clocks['isStopawatchStarted'])  {
            {
                stopClock(clocks);
                generatePopUp(1,clocks);
            }
        }else
        {
            alert('Cannot reset without a start')
        }
        console.log("bottone dello stopwatch " , buttonS.innerHTML)

    })
}
function subjectAdd(displaySubjects){
    const regex = /^(?![\d'])[a-z0-9' ]*[a-z0-9]$/i;
    var subChoosen = document.getElementById("scelta");
    const newSubject = document.getElementById("newsub");
    var addSubject;
    newSubject.addEventListener("click", ()=> {
        const textMateria = document.getElementById("add_materie");
        addSubject = document.getElementById("add_materie").value;
        console.log(addSubject)
        if (!isSubPresent(addSubject,subChoosen)) {
            alert("This subject has already been created");
        }
        else {
            if(addSubject==="") {
                alert("Empty space is not a subject");
            }
            else{
                if (!textMateria.value.match(regex)) {
                    alert('Input does not match the regex pattern. Please enter a string without starting with a space, number, or special characters.');
                }else{
                    textMateria.value = "";

                    dataTime['subjectName'] = addSubject;
                    databaseDelivery(dataTime, 2);
                    var optionElement = document.createElement("option");
                    optionElement.value = addSubject;
                    optionElement.textContent = addSubject;
                    subChoosen.appendChild(optionElement);
                }
            }
        }
    })
}


window.addEventListener("DOMContentLoaded", () => {

    const clocks={      //di gestione
        idTimerOrStopwatch : false,   //0  stopwatch , 1 timer
        idTimerEndOrStop:false ,      //0  end , 1 stop
        startTimeTI : 1500, // default, it do not changes its values during the timer
        modifiableTimeTimer:0, // it changes its value during timer
        startTimeST :0,     //default
        modifiableTimeStopwatch:0,
        isTimerStarted  : false,// false: timer is at max, true:timer is running
        isStopawatchStarted : false, // false : stopwatch is at max , true : stopwatch is running
        interval:0,
        shortBreak: 20,
        middleBreak:900,
        longBreak :1800,
        timegone:0,
    }

    var displaySubjects=[];
    subjectsRequests(displaySubjects);

    swipe(clocks);

        sessionStopwatch(clocks);


        sessionTimer(clocks);


    subjectAdd(displaySubjects);
});