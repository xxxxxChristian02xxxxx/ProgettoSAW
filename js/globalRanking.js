document.addEventListener('DOMContentLoaded', function() {
    const table = document.querySelector('#globalRankTable tbody');
    const windowHeight = window.innerHeight;
    const podiumPopup = document.getElementById('podiumPopup');
    const podium = document.querySelector('.podium');
    fetch("../backend/be_globalRanking.php")
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

            if(podium.children[0]){
                podium.children[0].style.height = windowHeight *0.3;
            }
            if(podium.children[1]){
                podium.children[1].style.height = windowHeight * 0.5;
            }
            if(podium.children[2]){
                podium.children[2].style.height = windowHeight * 0.1;
            }

            podium.style.transform = 'rotateX(180deg)';
            podiumPopup.style.display = 'block';
            document.querySelector('.overlay').style.display = 'block';
        })
        .catch(error => {
            console.error("Si è verificato un errore: ", error);
        });
});

