function populateTable(data, currentPage, rowsPerPage, table) {
    if (table) {

        table.innerHTML = '';

        var start = (currentPage - 1) * rowsPerPage;
        var end = Math.min(start + rowsPerPage, data.length);

        for (var i = start; i < end; i++) {
            var newRow = document.createElement('tr');

            if (table === document.querySelector('#globalRankTable tbody')) {
                var newCell = document.createElement('td');
                newCell.innerText = i - start + 1;
                newRow.appendChild(newCell);
            }
            Object.keys(data[i]).forEach(function (key) {
                var newCell = document.createElement('td');
                if (key === 'ROLES') {
                    var promoteDemoteButton = document.createElement('button');

                    if (parseInt(data[i][key])) {
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
                    if (parseInt(data[i][key])) {
                        banUnbanButton.innerHTML = 'Unban';
                        banUnbanButton.setAttribute('data-content', 'Unban');
                    } else {
                        banUnbanButton.innerHTML = 'Ban';
                        banUnbanButton.setAttribute('data-content', 'Ban');
                    }
                    banUnbanButton.className = "banUnbanButton";
                    newCell.appendChild(banUnbanButton);
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

        updatePagination(data, currentPage, rowsPerPage, table);
    }
}

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

function changeRowsPerPage() {
    var rowsPerPage = parseInt(document.getElementById('rowsPerPage').value);
    var currentPage = 1;

    getData(currentPage, rowsPerPage);
}

function searchTable(data, input, currentPage, rowsPerPage, table) {
    var filter, text;

    filter = input.value.toUpperCase();

    table.innerHTML = '';

    var foundIndexes = [];

    for(i=0; i<data.length; i++){
        var found = false;
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

    var filteredData = foundIndexes.map(function(index) {
        return data[index];
    });

    populateTable(filteredData,currentPage,rowsPerPage, table);
}


function populateColumnSelection(data, table) {
    var columnSelection = document.getElementById('columnFilter');
    columnSelection.innerHTML='';

    var emptyOption = document.createElement('option');
    emptyOption.value = '';
    emptyOption.text = 'Select column';
    columnSelection.appendChild(emptyOption);

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
    var valueFilterDiv = document.querySelectorAll('.valueFilter');
    valueFilterDiv.forEach(function (divElement) {
        divElement.style.display = 'none';
    });
    var rowsPerPage = document.getElementById('rowsPerPage').value;
    populateTable(data, 1, rowsPerPage, table);
}