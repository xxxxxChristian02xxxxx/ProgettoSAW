<!DOCTYPE html>
<html lang="en">
<head>
    <title>Global ranking</title>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../ranking.css">
    <link rel="stylesheet" type="text/css" href="../editTable.css">
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
    <div class="globalRank">
        <h1>Global rank</h1>
        <div id="globalRankTableContainer">
            <div class="search-options">
                <div class="options">
                    <label for="rowsPerPage">Show</label>
                    <select id="rowsPerPage" onchange="changeRowsPerPage()">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                    </select>
                    <span> rows</span>
                </div>
                <div class="search">
                    <label for="editUserSearch">Search:</label>
                    <input type="text" id="editUserSearch" placeholder="Search...">
                </div>
            </div>
            <div class="filters">
                <div class="columnFilter">
                    <label for="columnFilter">Filter by: </label>
                    <select id="columnFilter">
                    </select>
                </div>

                <div class="valueFilter">
                    <label for="valueFilter">Value: </label>
                    <select id="valueFilter">
                    </select>

                    <button id="filterButton">Filter</button>
                    <button id="resetFilter">Reset Filter</button>
                </div>
            </div>
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
            <div id="pagination"></div>
        </div>
        <div id="podiumPopup" class="popup">
            <h1>Global podium</h1>
            <div id="closePopup">
                <button id="closePopupButton">x</button>
            </div>
            <div class="podium">
                <div id="secondPlace">
                    <p id="PsecondPlaceName"></p>
                    <p id="PsecondPlace">2nd</p>
                </div>
                <div id="firstPlace">
                    <p id="PfirstPlaceName"></p>
                    <p id="PfirstPlace">1st</p>
                </div>
                <div id="thirdPlace">
                    <p id="PthirdPlaceName"></p>
                    <p id="PthirdPlace">3rd</p>
                </div>
            </div>
            <p>Close the popup to show the global rank</p>
        </div>
        <div class="overlay"></div>
        <script src="../js/editTables.js"></script>
        <script src="../js/globalRanking.js"></script>
    </div>
</body>
</html>