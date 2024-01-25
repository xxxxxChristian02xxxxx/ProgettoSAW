
    const startElement_S= document.getElementById("Stopwatch");
    const resetElement_S= document.getElementById("resetStopwatch");
    const timeElement_S= document.getElementById("timeStopwatch");
    let interval2;
    let bottonRound2 =0;
    let startTime = 0;

    startElement_S.addEventListener('click', function() {
    // Verifica lo stato del bottone
    if (bottonRound2 === 0) {
    // Prima volta che è stato cliccato
    console.log('Primo clic');
    startStopwatch();
    // Aggiorna lo stato
    bottonRound2 = 1;
} else {
    // Seconda volta che è stato cliccato
    console.log('Secondo clic');
    stopStopwatch();
    // Aggiorna lo stato
    bottonRound2 = 0;
}
})

    function updateStopwatch() {
    let currentTime = new Date();
    let elapsedTime = startTime ? Math.floor((currentTime - startTime) / 1000) : 0;
    let minutes = Math.floor(elapsedTime / 60);
    let seconds = elapsedTime % 60;
    /*
        funzione per stampare a schermo il tempo che scorre ,padStart serve per stampare 0, col lo 0 davanti
        con 2 -> voglio 2 digit e se non ho nulla metto "0" di default
    */
    let formattedTime2 = `${minutes.toString().padStart(2, "0")}: ${seconds.toString().padStart(2, "0")}`;
    timeElement_S.innerHTML = formattedTime2;
}

    function startStopwatch() {
    toggleButton('Stopwatch');
    startTime = new Date();
    /*intervallo che deve essere aggiornato ogni 1000 ms*/
    interval2 = setInterval(() => {
    updateStopwatch();
}, 1000)
}

    function resetStopwatch() {
    console.log("resetStopwatch")
    clearInterval(interval2);
    interval2 = undefined;
    startTime = null;
    updateStopwatch();
    bottonRound2 = 0;
    console.log(startElement.innerHTML);
    if(startElement_S.innerHTML === "Stop") {
    toggleButton('Stopwatch');
}
}

    function stopStopwatch() {
    clearInterval(interval2);
    toggleButton('Stopwatch');
}
    resetElement_S.addEventListener("click", resetStopwatch)
