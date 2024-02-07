const table = document.querySelector('#personalRankTable tbody')

fetch("../backend/be_personalRanking.php")
.then(response => {
    return response.json();
})
.then(data => {
    for(var i=0; i<data.length; i++) {
        var newRow = document.createElement('tr');
        var newCell = document.createElement('td');
        newCell.textContent = i+1;
        newRow.appendChild(newCell)
        //Aggiunta delle colonne alla riga
        Object.keys(data[i]).forEach(function (key) {
            var newCell = document.createElement('td');
            newCell.textContent = data[i][key];
            newRow.appendChild(newCell)
        });

        table.appendChild(newRow);
    }
})
.catch(error => {
    console.error("Si è verificato un errore: ", error);
});