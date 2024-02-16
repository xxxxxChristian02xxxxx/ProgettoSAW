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
    <title>Edit users</title>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../editusers.css">
    <link rel="stylesheet" type="text/css" href="../editTable.css">
    <link rel="stylesheet" type="text/css" href="../popup.css">
</head>
<body>
    <div class="editUser">
        <h1>Edit users</h1>
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

        <table class="dataTable" id="edituserTable">
            <thead>
                <th>ID</th>
                <th>NAME</th>
                <th>LASTNAME</th>
                <th>EMAIL</th>
                <th>ROLES</th>
                <th>BANNED</th>
                <th>MONEY</th>
                <th>DELETE USER</th>
            </thead>
            <tbody></tbody>
        </table>

        <div id="popUp" class="hidden">
            <div id="popUpContent">
            </div>
        </div>

        <div id="pagination"></div>
        <script src="../js/editusers.js"></script>
        <script src="../js/editTables.js"></script>
        <script src="../js/promoteDemote.js"></script>
        <script src="../js/banUnban.js"></script>
        <script src="../js/modifyMoney.js"></script>
        <script src="../js/deleteUser.js"></script>
    </div>
</body>
</html>

