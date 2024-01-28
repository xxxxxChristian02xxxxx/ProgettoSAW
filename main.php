<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_COOKIE['ReMe'])) {
        //fa qualcosa: query per verificare se esiste
        include('backend/function_files/connection.php');
        $con = connect();


        $cookie_val = $_COOKIE['ReMe'];
        $decodedata = json_decode($cookie_val, true);
        $token_val = $decodedata['token_value'];
        $id = $decodedata['id'];
        $query = "SELECT EXPIRE FROM USERS WHERE TOKEN = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $token_val);
        $stmt->execute();

        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $expire = $res->fetch_assoc();

            //Se scaduto rimanda alla pagina di login
            if (date(time()) > $expire['EXPIRE']) {
                header("Location: frontend/login.php");
            } else {
                include('backend/function_files/session.php');
                setSession($id);
            }
        }else{
            //todo: create error
        }
        $stmt->close();
    }

    include('frontend/header.php');
    include('backend/function_files/session.php');
    $session = getSession(true);
    echo "<h2>Welcome " . $session['firstname'] . " " . $session['lastname'] .  " </h2>" ;


?>
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link href='dressing.css' rel='stylesheet' type='text/css'>
</head>


<body>
<div>
    <div>
            <label for="Testo_materie">Scegli la materia:</label>
            <input type="text" id="Testo_materie" name="Testo_materie">
            <select id="scelta" name="scelta">

                <div>
                    <option>
                        opzione 1
                    </option>
                    <spam>
                        <button>
                            -
                        </button>
                    </spam>
                </div>

            </select>
    </div>
    <div class="containerTimer">
        <div class="title">
            <h1> Timer</h1>
        </div>
        <p id="timeTimer" class ="timer">25:00</p>
        <div id ="timerBottons">
            <button id = "Timer">Start</button>
            <button id = "resetTimer">Reset</button>
        </div>
    </div>
    <div class="container_popup">
    <div class="popup" id="popup">
        <div class="popup-inner">
            <h2> Are you sure to leave? </h2>
            <div id ="statistiche_sessioone_studio ">
                <p>
                    <div>
                            <div>
                                <p id="durata_session">durata sessione:</p>
                                <span>
                                    <p id="tempo_durata_session">tempo</p>
                                </span>
                            </div>
                            <div>
                                <p id="materia_studiata">materia studiata:</p>
                                <span>
                                    <p id="materia_materia_studiata">materia</p>
                                </span>
                            </div>
                            <div>
                                <p id="soldi_ottenuti">soldi ottenuti:</p>
                                <span>
                                    <p id="soldi_soldi_ottenuti">soldi</p>
                                </span>
                            </div>
                            <p></p>
                     </div>
                </p>
            </div>
            <div id="descrizione">
                <div>
                    <textarea id ="area_descrizione "rows="4" cols="50" placeholder="Scrivi qui..."></textarea>

                </div>

            </div>

            <div >
                <span class="popup_button">
                <botton id="closePopUp" > yes </botton>
                </span>
                <span class="popup_button">
                    <botton id="cancelPopup">  Cancel </botton>
                </span>
            </div>
        </div>
    </div>
    </div>

    <div class="containerStopwatch">
        <div class="title">
            <h1> Stopwatch</h1>
        </div>
        <p id="timeStopwatch" class ="timer">00:00</p>
        <div id ="stopwatchBottons">
            <button id = "Stopwatch" >Start</button>
            <button id = "resetStopwatch">Reset</button>

        </div>
    </div>

</div>

<script>
    let interval;
    let timeLeft = 1500; /*tempo rimasto : 1500 indica 25 secondi*/
    var counting  = false; //
    var button = document.getElementById("Timer");
    const startTime ="25 : 00" ;
    var timeSpentForMoney =0;

    const subjectName=null;
    const startElement= document.getElementById("Timer");
    const resetElement= document.getElementById("resetTimer");
    const timeElement= document.getElementById("timeTimer");
    const closeButton = document.getElementById("closePopUp");
    const cancelButton = document.getElementById("cancelPopup")
    const popUp =document.getElementById("popup");

    var timeDuratioSession =document.getElementById("tempo_durata_session");
    var subSubStudied = document.getElementById("materia_materia_studiata");
    var moneyMoneyObtained= document.getElementById("soldi_soldi_ottenuti")
    var descriptionArea=document.getElementById("area_descrizione ");


    var formattedTime;
    //-------------------------EVENTO PER DIRE SE SONO IN STOP OPPURE IN START -------------------------//
    startElement.addEventListener('click', function() {
        counting =true;
        // Verifica lo stato del bottone
        if (button.innerHTML === "Start") {
            // Prima volta che è stato cliccato
            console.log('Primo clic');

            console.log(counting);
            startTimer();
            // Aggiorna lo stato
            button.innerHTML = "Stop";
            button.setAttribute("aria-label", "Stop");
        } else {
            // Seconda volta che è stato cliccato
            console.log('Secondo clic');
            console.log(counting);
            stopTimer();
            // Aggiorna lo stato
            button.innerHTML = "Start";
            button.removeAttribute("aria-label");
        }

    })
    //-------------------------EVENTO PER DIRE SE SONO IN STOP OPPURE IN START -------------------------//
    ;

    if((formattedTime!==startTime)  ){
        resetElement.addEventListener("click",()=> {
             {
                 showStudySession();
                stopTimer();
                popUp.classList.add("open");//aggiungo il css
                counting = false
            }
        })
    }else
    {
        alert('There is no counter')
    }

    //-------------------------EVENTO PER DIRE CHIUDERE IL POPUP RESETTANDO -------------------------//

    closeButton.addEventListener("click",()=>{
        popUp.classList.remove("open");//aggiungo il css
        if(button.innerHTML==="Stop"){
            button.innerHTML = "Start";
            button.removeAttribute("aria-label");
        }
        resetTimer()

    })
    //-------------------------EVENTO PER DIRE CHIUDERE IL POPUP CONTINUANDO -------------------------//

    cancelButton.addEventListener("click",()=>{
        if(button.innerHTML==="Stop"){
            button.innerHTML = "Start";
            button.removeAttribute("aria-label");
        }
        popUp.classList.remove("open");//aggiungo il css
    })

    const dataTime={
        typeSession:null;
        timeSpent : document.getElementById("timeTimer"),
        money : timeSpentForMoney,
        subjactName: null,
        description:null,
        season:null;
    }
</script>

<script>
    const subChoosen = document.getElementById("scelta");

    //-------------------------EVENTO PER FARE IL DISPLAY DELLE MATERIE -------------------------//
    window.addEventListener("DOMContentLoaded", () => {
        var displaySubjects = ["italiano", "matematica","inglese"];
        populateSelect(displaySubjects);
    });



</script>


<script src="js/main_timer.js"></script>


<script src="js/main_choose_sub.js"></script>




<footer>
    <p>Copyright © 2023. All rights reserved   .</p>
</footer>
</body>
</html>
