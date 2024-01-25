<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if (isset($_COOKIE['ReMe'])) {
        //fa qualcosa: query per verificare se esiste
        include('backend/function_files/connection.php');
        $con = connect();


        $cookie_val = $_COOKIE['ReMe'];
        $decodedata = json_decode($cookie_val, true);
        $token_val = $decodedata['token_value'];
        $id = $decodedata['id'];
        $query = "SELECT EXPIRE FROM USERS WHERE TOKEN = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $token_val);
        $stmt->execute();

        $res = $stmt->get_result();

        if ($res->num_rows == 1) {
            $expire = $res->fetch_assoc();

            //Se scaduto rimanda alla pagina di login
            if (date(time()) > $expire['EXPIRE']) {
                header("Location: frontend/login.php");
            } else {
                include('backend/function_files/session.php');
                setSession($id);
            }
        }else{
            //todo: create error
        }
        $stmt->close();
    }
    //Verifica che la sessione sia attiva
    include('backend/function_files/session.php');
    //Aggiunta dell'header
    include('frontend/header.php');
    $session = getSession(true);
?>
<html lang="en">
<head>
    <link href="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.css" rel="stylesheet">

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/datatables.min.js"></script>
</head>
<body>
    <div class="selectOptions">
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
    <table class="studySessionTable">
        <thead>
        <tr>
            <th>SESSION ID</th>
            <th>TYPE</th>
            <th>DATE</th>
            <th>TOTAL TIME</th>
            <th>TOTAL REWARD</th>
            <th>SEASON</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div id="pagination"></div>
</body>
</html>

<script>
    // Configurazione visualizzazione tabella
    var currentPage = 1;
    var rowsPerPage = 5;

    function getData(currentPage) {
        fetch('backend/be_studysessions.php')
            .then(response => response.json())
            .then(data => {
                populateTable(data, currentPage);
                updatePagination(data, currentPage);
            })
            .catch(error => console.error('Error in reaching data:', error));
    }
    document.addEventListener('DOMContentLoaded', function () {
        // Si ottengono i dati
        getData(currentPage);
    });

    // Funzione per popolare la tabella
    function populateTable(data, currentPage) {
        var table = document.querySelector('.studySessionTable tbody');

        //Pulizia della tabella
        table.innerHTML = '';

        // Indice del primo elemento da visualizzare nella tabella
        var start = (currentPage - 1) * rowsPerPage;
        // Indice ultimo elemento da visualizzare nella tabella per la pagina corrente
        var end = Math.min(start + rowsPerPage, data.length);

        //Popolamento della tabella
        for(var i=start; i<end; i++){
            var newRow = document.createElement('tr');
            //Aggiunta delle colonne alla riga
            Object.keys(data[i]).forEach(function (key) {
                var newCell = document.createElement('td');
                newCell.textContent = data[i][key];
                newRow.appendChild(newCell)
            });

            table.appendChild(newRow);
        }

        // Aggiornamento controlli di paginazione
        updatePagination(data, currentPage);
    }

    // Funzione per la gestione della paginazione
    function updatePagination(data, currentPage) {

        var totalPages = Math.ceil(data.length / rowsPerPage);

        var paginationContainer = document.getElementById('pagination');
        paginationContainer.innerHTML = '';

        for(var i = 1; i <= totalPages; i++){

            var button = document.createElement('button');
            button.textContent = i.toString();
            button.onclick = function () {
                currentPage = parseInt(this.textContent.toString());
                getData(currentPage);
            };

            if(i === currentPage){
                button.classList.add('active');
            }

            paginationContainer.appendChild(button);
        }
    }

    // Funzione per cambaire il numero di righe per pagina
    function changeRowsPerPage() {
        rowsPerPage = parseInt(document.getElementById('rowsPerPage').value);
        currentPage = 1;

        getData(currentPage);
    }

</script>