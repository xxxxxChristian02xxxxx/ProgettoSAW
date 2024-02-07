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

            banUnban();
        })
        .catch(error => console.error('Error in reaching data:', error));
}
// Funzione per cambiare il ruolo di un utente
function banUnban() {
    // Come prima cosa accedo alle righe della tabelle
    // querySelectorAll restituisce una lista, in questo caso la lista di quelle che sono le righe della tabella
    var rows = document.querySelectorAll('#edituserTable tbody tr');
    // Per ogni riga
    rows.forEach(function(row){
        // Accedo alla cella relativa al campo ban (sapendo qual è la struttura della tabella ho fatto l'accesso tramite indice)
        var cell = row.cells[6];
        if(cell){
            // Memorizzo l'email relativa alla cella che è stata cliccata (anche in questo caso conoscendo la struttura so dove è memorizzata l'email)
            var email = row.cells[3];

            // Aggiungo un listener relativo al click sulla cella della tabella
            // Quando clicco -> chiamata fetch a file che faccia lo sban o il ban nel db
            cell.addEventListener('click', function() {
                fetch("../backend/function_files/banUnban.php", {
                    method: "POST",
                    headers: {
                        'Content-type':'application/json'
                    },
                    body: JSON.stringify({action: 'banUnban', email: email.innerText})
                })
                    .then(response => {
                        console.log('okkk');
                    })
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.error("qualcosa è andato storto");
                })
            })
        }
    });

}