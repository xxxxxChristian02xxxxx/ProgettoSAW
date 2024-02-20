<!DOCTYPE html>
<html lang="en">
<head>
    <title>Personal ranking</title>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../editTable.css">
    <link rel="stylesheet" type="text/css" href="../ranking.css">
</head>
<body>
    <?php
    session_start();

    //Verifica se impostato un cookie
    include('../backend/function_files/verifyCookie.php');
    verifyCookie();
    //Aggiunta dell'header
    include('header.php');
    ?>
    <main class="wrapper">

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

        <div id="podiumPopup" class="popup">
            <h1>Personal podium</h1>
            <div id="closePopup">
                <button id="closePopupButton">x</button>
            </div>
            <div class="podium">
                <div id="secondPlace">
                    <p id="PsecondPlaceSubject"></p>
                    <p id="PsecondPlace">2nd</p>
                </div>
                <div id="firstPlace">
                    <p id="PfirstPlaceSubject"></p>
                    <p id="PfirstPlace">1st</p>
                </div>
                <div id="thirdPlace">
                    <p id="PthirdPlaceSubject"></p>
                    <p id="PthirdPlace">3rd</p>
                </div>
            </div>
            <p>Close the popup to show the global rank</p>
        </div>
        <div class="overlay"></div>
        <script src="../js/personalRanking.js"></script>
    </div>
    </main>
    <footer id="footer">
        <?php
        include('footer.html');
        ?>
    </footer>
</body>
</html>
