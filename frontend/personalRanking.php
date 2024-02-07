<?php
session_start();
//Verifica che la sessione sia attiva
include('../backend/function_files/session.php');
//Aggiunta dell'header
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Personal ranking</title>
</head>
<body>
    <div class="personalRank">
        <h1>My personal rank</h1>
        <div id="personalRankTableContainer">
            <table class="dataTable" id="personalRankTable">
                <thead>
                    <tr>
                        <th>POSITION</th>
                        <th>SUBJECT</th>
                        <th>TOTAL TIME STUDIED</th>
                        <th>TOTAL REWARD</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <script src="../js/personalRanking.js"></script>
    </div>
</body>
</html>
