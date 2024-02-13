<?php
session_start();

//Verifica se impostato un cookie
include('../backend/function_files/verifyCookie.php');
verifyCookie();
//Aggiunta dell'header
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Personal ranking</title>
    <link rel="stylesheet" type="text/css" href="../globalRanking.css">
</head>
<body>
    <div class="globalRank">
        <h1>Global rank</h1>
        <div id="globalRankTableContainer">
            <table class="dataTable" id="globalRankTable">
                <thead>
                <tr>
                    <th>POSITION</th>
                    <th>USER</th>
                    <th>MOST EXPENSIVE STICKER</th>
                    <th>TOTAL STUDY HOURS</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="podiumPopup" class="popup">
            <div class="podium">
                <div id="secondPlace"></div>
                <div id="firstPlace"></div>
                <div id="thirdPlace"></div>
            </div>
        </div>
        <div class="overlay"></div>
        <script src="../js/globalRanking.js"></script>
    </div>
</body>
</html>