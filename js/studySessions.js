const table = document.querySelector('#studySessionsTable tbody');

document.addEventListener('DOMContentLoaded', function () {
    // Si ottengono i dati
    getData(1, 5);
});

function getData(currentPage, rowsPerPage) {
    fetch('../backend/be_studysessions.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) { // No content
                return null;
            }
            return response.json();
        })
        .then(data => {
            populateTable(data, currentPage, rowsPerPage, table);
            updatePagination(data, currentPage, rowsPerPage, table);

            populateColumnSelection(data, table);

            var input = document.getElementById("studySessionSearch");
            input.addEventListener("input", function() {
                if(this.value === ""){
                    populateTable(data, currentPage, rowsPerPage, table);
                }
                else{
                    searchTable(data, input, currentPage, rowsPerPage, table);
                }
            });
        })
        .catch(error => console.error('Error in reaching data:', error));
}