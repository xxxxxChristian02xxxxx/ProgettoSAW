const table = document.querySelector('#studySessionsTable tbody');
document.addEventListener('DOMContentLoaded', function () {
    getData(1, 5);
});

function getData(currentPage, rowsPerPage) {
    fetch('../backend/be_studysessions.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) {
                return null;
            }
            return response.json();
        })
        .then(data => {
            Object.keys(data).forEach(function(i){
                if(parseInt(data[i]['TYPE'])){
                    data[i]['TYPE']="Stopwatch";
                }
                else{
                    data[i]['TYPE']="Timer";
                }
                data[i]['TOTAL_TIME'] = parseInt(data[i]['TOTAL_TIME']);
                let hours = Math.floor(data[i]['TOTAL_TIME']/3600);
                let minutes = Math.floor((data[i]['TOTAL_TIME']%3600)/60);
                let seconds = Math.floor((data[i]['TOTAL_TIME']%3600)%60);
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
                data[i]['TOTAL_TIME'] = formattedTime;
            })
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