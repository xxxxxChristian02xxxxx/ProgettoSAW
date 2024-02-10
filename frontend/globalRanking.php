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
        <script src="../js/globalRanking.js"></script>
    </div>
</body>
</html>