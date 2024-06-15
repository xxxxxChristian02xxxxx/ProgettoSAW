const table = document.querySelector('#globalRankTable tbody');
const windowHeight = window.innerHeight;
const podiumPopup = document.getElementById('podiumPopup');
const podium = document.querySelector('.podium');

document.addEventListener('DOMContentLoaded', function() {
    getData(1, 5);
});

function getData(currentPage, rowsPerPage) {
    fetch("../backend/be_globalRanking.php")
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
            console.log(data)
            Object.keys(data).forEach(function(i){
                data[i]['TOTAL_STUDY_TIME'] = parseInt(data[i]['TOTAL_STUDY_TIME']);
                let hours = Math.floor(data[i]['TOTAL_STUDY_TIME']/3600);
                let minutes = Math.floor((data[i]['TOTAL_STUDY_TIME']%3600)/60);
                let seconds = Math.floor((data[i]['TOTAL_STUDY_TIME']%3600)%60);
                let formattedTime;
                if(hours){
                    formattedTime = hours + "h " + minutes + "m " + seconds + "s";
                }
                else if(minutes){
                    formattedTime = minutes + "m " + seconds + "s";
                }
                else{
                    formattedTime = seconds + "s";
                }
                data[i]['TOTAL_STUDY_TIME'] = formattedTime;
            })
            var first = document.getElementById('PfirstPlaceName');
            var second = document.getElementById('PsecondPlaceName');
            var third = document.getElementById('PthirdPlaceName');

            if (data[0]) {
                first.textContent = data[0]['USER'];
                first.textContent = data[0]['USER'];
            }
            if (data[1]) {
                second.textContent = data[1]['USER'];
            }
            if (data[3]) {
                third.textContent = data[2]['USER'];
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
        .catch(error => {
            console.error("Si è verificato un errore: ", error);
        });
}

const closePopup = document.getElementById('closePopupButton');
    closePopup.addEventListener('click', function() {
        podiumPopup.style.display = 'none';
        document.querySelector('.overlay').style.display = 'none';
    });



