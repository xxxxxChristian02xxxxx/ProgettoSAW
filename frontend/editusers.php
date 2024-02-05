<?php
session_start();

session_start();
//Verifica che la sessione sia attiva
include('../backend/function_files/session.php');
//Aggiunta dell'header
include('header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit users</title>
</head>
<body>
    <div class="search-options">
        <div class="options">
            <label for="rowsPerPage">Show </label>
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
            <label for="search">Search:</label>
            <input type="text" id="search" placeholder="Search...">
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

    <table class="dataTable" id="edituserTable">
        <thead>
            <th>ID</th>
            <th>NAME</th>
            <th>LASTNAME</th>
            <th>EMAIL</th>
            <th>PASSWORD</th>
            <th>ROLES</th>
            <th>BANNED</th>
            <th>REMEMBER</th>
            <th>TOKEN</th>
            <th>EXPIRE</th>
            <th>MONEY</th>
        </thead>
        <tbody></tbody>
    </table>
    <div id="pagination"></div>

<script src="../js/editusers.js"></script>
</body>
</html>
