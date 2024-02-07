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
    <title>Study sessions</title>
</head>
<body>
    <div class="studySessions">
        <h1>My study sessions</h1>
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
                <label for="studySessionSearch">Search:</label>
                <input type="text" id="studySessionSearch" placeholder="Search...">
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

        <div id="studySessionTableContainer">
            <table class="dataTable" id="studysessionsTable">
                <thead>
                <tr>
                    <th>SESSION ID</th>
                    <th>TYPE</th>
                    <th>DATE</th>
                    <th>TOTAL TIME</th>
                    <th>TOTAL REWARD</th>
                    <th>SEASON</th>
                    <th>DESCRIPTION</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div id="pagination"></div>

        <div id="rankRedirect">
            <a href="personalRanking.php">Show my personal rank</a>
        </div>
        <script src="../js/studySessions.js"></script>
        <script src="../js/editTables.js"></script>
    </div>
</body>
</html>