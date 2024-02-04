document.write('<script type="text/javascript" src="../js/editTables.js"></script>')
var table = document.querySelector('#edituserTable tbody')

document.addEventListener('DOMContentLoaded', function () {
    // Si ottengono i dati
    getData(currentPage, table);
});

function getData(currentPage, table) {
    fetch('../backend/be_editusers.php')
        .then(response => response.json())
        .then(data => {
            populateTable(data, currentPage, table);
            updatePagination(data, currentPage);

            populateColumnSelection(data);

            document.getElementById("search").addEventListener("input", function () {
                if (this.value === "") {
                    populateTable(data, currentPage, table);
                } else {
                    searchTable(data, table);
                }
            });
        })
        .catch(error => console.error('Error in reaching data:', error));
}


