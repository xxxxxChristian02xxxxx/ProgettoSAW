// Funzione per popolare la tabella
function populateTable(data, currentPage, rowsPerPage, table) {
    if (table) {
        //Pulizia della tabella
        table.innerHTML = '';

        // Indice del primo elemento da visualizzare nella tabella
        var start = (currentPage - 1) * rowsPerPage;
        // Indice ultimo elemento da visualizzare nella tabella per la pagina corrente
        var end = Math.min(start + rowsPerPage, data.length);

        // Popolamento della tabella
        for (var i = start; i < end; i++) {
            var newRow = document.createElement('tr');
            // Aggiunta delle colonne alla riga - iterazione attraverso tutte le chiavi dell'oggetto data[i]
            // e applicazione di una funzione a ciascuna di esse
            if (table === document.querySelector('#globalRankTable tbody')) {
                var newCell = document.createElement('td');
                newCell.innerText = i - start + 1;
                newRow.appendChild(newCell);
            }
            Object.keys(data[i]).forEach(function (key) {
                var newCell = document.createElement('td');

                if (key === 'ROLES') {
                    var promoteDemoteButton = document.createElement('button');
                    if (data[i][key]) {
                        promoteDemoteButton.innerHTML = 'Demote';
                        promoteDemoteButton.setAttribute('data-content', 'Demote');
                    } else {
                        promoteDemoteButton.innerHTML = 'Promote';
                        promoteDemoteButton.setAttribute('data-content', 'Promote');
                    }
                    promoteDemoteButton.className = "promoteDemoteButton";
                    newCell.appendChild(promoteDemoteButton);
                }
                else if (key === 'BANNED') {
                    var banUnbanButton = document.createElement('button');
                    if (data[i][key]) {
                        banUnbanButton.innerHTML = 'Unban';
                        banUnbanButton.setAttribute('data-content', 'Unban');
                    } else {
                        banUnbanButton.innerHTML = 'Ban';
                        banUnbanButton.setAttribute('data-content', 'Ban');
                    }
                    banUnbanButton.className = "banUnbanButton";
                    newCell.appendChild(banUnbanButton);
                }
                else if (key === 'DATE'){
                    var date = new Date(data[i][key]);

                    newCell.textContent = `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`;
                }
                else {
                    newCell.textContent = data[i][key];
                }
                newRow.appendChild(newCell)

            });

            if (table === document.querySelector('#edituserTable tbody')) {
                var deleteCell = document.createElement('td');
                newRow.appendChild(deleteCell);
                var deleteButton = document.createElement('button');
                deleteButton.innerHTML = 'X';
                deleteButton.className = "deleteButton";
                deleteCell.appendChild(deleteButton);
            }

            table.appendChild(newRow);

        }

        if (table === document.querySelector('#edituserTable tbody')) {
            promoteDemoteUser();
            banUnban();
            modifyMoney();
            deleteUser();
        }

        // Aggiornamento controlli di paginazione
        updatePagination(data, currentPage, rowsPerPage, table);
    }
}

// Funzione per la gestione della paginazione
function updatePagination(data, currentPage, rowsPerPage, table) {

    var totalPages = Math.ceil(data.length / rowsPerPage);

    var paginationContainer = document.getElementById('pagination');
    paginationContainer.innerHTML = '';

    for(var i = 1; i <= totalPages; i++){

        var button = document.createElement('button');
        button.textContent = i.toString();

        button.addEventListener('click', function () {
            currentPage = parseInt(this.textContent.toString());
            populateTable(data, currentPage, rowsPerPage, table);
        });

        if(i === currentPage){
            button.classList.add('active');
        }

        paginationContainer.appendChild(button);
    }

}

// Funzione per cambaire il numero di righe per pagina
function changeRowsPerPage() {
    var rowsPerPage = parseInt(document.getElementById('rowsPerPage').value);
    var currentPage = 1;

    getData(currentPage, rowsPerPage);
}

function searchTable(data, input, currentPage, rowsPerPage, table) {
    var filter, text;

    filter = input.value.toUpperCase();

    table.innerHTML = '';

    // Tengo traccia degli indici delle righe che soddisfano i criteri della ricerca
    var foundIndexes = [];

    // Iterazione attraverso le righe della struttura dati
    for(i=0; i<data.length; i++){
        var found = false;
        // Iterazione sulla colonna della riga
        for(j = 0; j<Object.values(data[i]).length; j++) {
            text = String(Object.values(data[i])[j]);
            if (text.toUpperCase().includes(filter)) {
                found = true;
                break;
            }
        }

        if(found) {
            foundIndexes.push(i);
        }

    }

    // Indice del primo elemento da visualizzare nella tabella
    var start = (currentPage - 1) * rowsPerPage;
    // Indice ultimo elemento da visualizzare nella tabella per la pagina corrente
    var end = Math.min(start + rowsPerPage, foundIndexes.length);

    // Vengono mostrate solo le righe che soddisfano i criteri di ricerca
    for(var k=start; k<end; k++){
        var rowIndex = foundIndexes[k];
        var rowData = data[rowIndex];

        var row = table.insertRow(-1);

        if(table === document.querySelector('#globalRankTable tbody')){
            var newCell = document.createElement('td');
            newCell.innerText = k-start+1;
            row.appendChild(newCell);
        }

        //Aggiunta delle colonne alla riga
        Object.keys(rowData).forEach(function (key) {
            var newCell = row.insertCell(-1);
            newCell.textContent = rowData[key];
        });
    }

    // Aggiornamento controlli di paginazione
    updatePagination(data, currentPage, table);
}


function populateColumnSelection(data, table) {
    var columnSelection = document.getElementById('columnFilter');
    columnSelection.innerHTML='';

    var emptyOption = document.createElement('option');
    emptyOption.value = '';
    emptyOption.text = 'Select column';
    columnSelection.appendChild(emptyOption);

    //Elenco colonne dalla prima riga dei dati
    var columns = Object.keys(data[0]);

    columns.forEach(function(column) {
        var option = document.createElement('option');
        option.value = column;
        option.text = column;
        columnSelection.appendChild(option);
    });

    columnSelection.addEventListener('change', function () {
        var selectedColumn = this.value;

        var filterValue = document.getElementById('valueFilter');
        if(selectedColumn === '') {
            filterValue.innerHTML = '';
            filterValue.style.display = 'none';
            return;
        }

        var filterValueElements = document.getElementsByClassName('valueFilter');
        if(filterValueElements.length > 0) {
            filterValueElements[0].style.display = 'inline';
        }
        populateValueSelection(data, selectedColumn, table);
    });
}

//Funzione per popolare dinamicamente la selezioni del valori ripsetto cui filtrare
function populateValueSelection(data, selectedColumn, table) {
    var filterValue = document.getElementById('valueFilter');
    filterValue.innerHTML = '';

    var emptyOption = document.createElement('option');
    emptyOption.value = '';
    emptyOption.text = 'Select value';
    filterValue.appendChild(emptyOption);

    var uniqueValues = [...new Set(data.map(item => item[selectedColumn]))];

    uniqueValues.forEach(function (value) {
        var option = document.createElement('option');
        option.value = value;
        option.text = value;
        filterValue.appendChild(option);
    });

    document.addEventListener('click', function(event) {
        if(event.target.id === 'filterButton'){
            filterTable(data, table);
        }
    });
}

function filterTable(data, table) {
    var filterColumn = document.getElementById('columnFilter').value;
    var filterValue = document.getElementById('valueFilter').value;
    var rowsPerPage = document.getElementById('rowsPerPage').value;

    // Confronta il valore di filterColumn per ogni riga con il valore del filtro filterValue usando il metodo filter sull'array data
    var filteredData = data.filter(function (row) {
        return row[filterColumn].toString() === filterValue.toString();
    });

    populateTable(filteredData, 1, rowsPerPage, table);

    document.addEventListener('click', function(event) {
        if(event.target.id === 'resetFilter'){
            resetFilters(data, table);
        }
    });
}

function resetFilters(data, table){
    document.getElementById('columnFilter').value='';
    document.getElementById('valueFilter').value='';
    var rowsPerPage = document.getElementById('rowsPerPage').value;
    populateTable(data, 1, rowsPerPage, table);
}