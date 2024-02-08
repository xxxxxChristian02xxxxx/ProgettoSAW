const table = document.querySelector('#edituserTable tbody')

document.addEventListener('DOMContentLoaded', function () {
    // Si ottengono i dati
    getData(1, 5);
});

function getData(currentPage, rowsPerPage) {
    fetch('../backend/be_editusers.php')
        .then(response => response.json())
        .then(data => {
            populateTable(data, currentPage, rowsPerPage, table);
            updatePagination(data, currentPage, rowsPerPage, table);

            populateColumnSelection(data, table);

            var input = document.getElementById("editUserSearch");
            input.addEventListener("input", function () {
                if (this.value === "") {
                    populateTable(data, currentPage, rowsPerPage, table);
                } else {
                    searchTable(data, input, currentPage, rowsPerPage, table);
                }
            });

        })
        .catch(error => console.error('Error in reaching data:', error));
}