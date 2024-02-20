<!DOCTYPE html>
<html lang="en">
<head>
    <title>Study sessions</title>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
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
    <main class="wrapper">

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
                <table class="dataTable" id="studySessionsTable">
                    <thead>
                    <tr>
                        <th>SUBJECT</th>
                        <th>TYPE</th>
                        <th>DATE</th>
                        <th>TOTAL TIME</th>
                        <th>TOTAL REWARD</th>
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
    </main>
    <footer id="footer">
        <?php
        include('footer.html');
        ?>
    </footer>
</body>
</html>