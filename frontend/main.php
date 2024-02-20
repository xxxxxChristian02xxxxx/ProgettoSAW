<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../main_dressing.css">
</head>

<body>
<?php
session_start();
//Verifica se è impostato un cookie
include("../backend/function_files/verifyCookie.php");
verifyCookie();

//Aggiunta dell'header
include('header.php');

$session = getSession(true);
echo "<h1>Welcome " . $session['firstname'] . " " . $session['lastname'] .  " </h1>" ;
?>
<main class="wrapper">

    <div class="subjectChoose">
        <span>
            <label for="scelta">Choose subject:</label>
            <select id="scelta" name="scelta"></select>
        </span>
        <span>
            <label for="add_materie">Add new subject:</label>
            <input type="text" id="add_materie" name="Testo_materie">
            <button id="newsub"> + </button></span>
        </span>
    </div>

    <div class="vertical-grid">
        <div class="column left-button">
            <button class ="swipeButton" id="buttom-Swipe-left"> &lt;&lt; </button>
        </div>
        <div class="column center">
            <div class="external-container">
            <div class="container" id="containertimer">
                <div class="title">
                    <h1 id ="timerTitle">Timer</h1>
                </div>
                <p id="timeTimer" class="timer"></p>
                <div >
                    <input type="range" id="TimerRange"></div>
                <div class="tasto">
                    <button id="TimerStart">Start</button>
                    <button id="resetTimer">Reset</button>
                </div>
            </div>
            </div>
            <div class="container" id ="constainerstopwatch">
                <div class="title">
                    <h1> Stopwatch</h1>
                </div>
                <p id="timeStopwatch" class ="timer"  >00:00 </p>
                <div id ="stopwatchBottons">
                    <button id = "startStopwatch" >Start</button>
                    <button id = "resetStopwatch">Reset</button>
                </div>
            </div>

        </div>
        <div class="column right-button">
            <button class="swipeButton" id="buttom-Swipe-right"> >> </button>
        </div>
    </div>
    <div class="container_popup" id="popUpMain">
        <div class="popup" id="popUpContentMain"></div>
    </div>

    <script src="../js/main.js"></script>
    <script src="../js/main_timer.js"></script>
    <script src="../js/main_popup.js"></script>
</main>
    <footer id="footer">
    <?php
    include('footer.html');
    ?>
</footer>
</body>
</html>

