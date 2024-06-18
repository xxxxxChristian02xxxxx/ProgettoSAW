const table = document.querySelector('#personalRankTable tbody')
const windowHeight = window.innerHeight;
const podiumPopup = document.getElementById('podiumPopup');
const podium = document.querySelector('.podium');

fetch("../backend/be_personalRanking.php")
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
    var first = document.getElementById('PfirstPlaceSubject');
    var second = document.getElementById('PsecondPlaceSubject');
    var third = document.getElementById('PthirdPlaceSubject');

    if (data[0]) {
        first.textContent = data[0]['SUBJECT'];
    }
    if (data[1]) {
        second.textContent = data[1]['SUBJECT'];
    }
    if (data[2]) {
        third.textContent = data[2]['SUBJECT'];
    }

    if (podium.children[0].children[0].innerText) {
        podium.children[0].style.height = windowHeight * 0.35;
    } else {
        podium.children[0].style.display = 'none';
    }

    if (podium.children[1].children[0].innerText) {
        podium.children[1].style.height = windowHeight * 0.5;
    } else {
        podium.children[1].style.display = 'none';
    }
    if (podium.children[2].children[0].innerText) {
        podium.children[2].style.height = windowHeight * 0.25;
    } else {
        podium.children[2].style.display = 'none';
    }

    podium.style.transform = 'rotateX(180deg)';
    podiumPopup.style.display = 'block';
    document.querySelector('.overlay').style.display = 'block';

    for(var i=0; i<data.length; i++) {

        var newRow = document.createElement('tr');
        var newCell = document.createElement('td');
        newCell.textContent = i+1;
        newRow.appendChild(newCell)
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

const closePopup = document.getElementById('closePopupButton');
closePopup.addEventListener('click', function() {
    podiumPopup.style.display = 'none';
    document.querySelector('.overlay').style.display = 'none';
});