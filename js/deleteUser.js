function deleteUser() {
    var rows = document.querySelectorAll('#edituserTable tbody tr');
    const dataTarget = {
        email: null,
    }
    // Per ogni riga
    rows.forEach(function (row) {
        // Accedo alla cella relativa al campo ban (sapendo qual è la struttura della tabella ho fatto l'accesso tramite indice)
        var cell = row.cells[7];
        if (cell) {
            // Memorizzo l'email relativa alla cella che è stata cliccata (anche in questo caso conoscendo la struttura so dove è memorizzata l'email)
            cell.addEventListener('click', function () {
                dataTarget['firstname'] = row.cells[1];
                dataTarget['lastname'] = row.cells[2];
                dataTarget['email'] = row.cells[3];
                popup(cell, row, dataTarget);
            });

        }
    });
}
function appendDeleteToContainer(popUpContent, dataTarget) {
    let gridHtml = '';
    gridHtml += generateDelete(dataTarget);
    popUpContent.innerHTML = gridHtml;
}

function generateDelete(dataTarget) {
    return `
        <h2> Delete User </h2>
                <span id="closePopUpButton" class="close">&times;</span>
                <div>
                   <p> You are deleting </p>
                   <div>
                        <p>- FIRSTNAME: <span class="popupValue">${dataTarget['firstname'].innerText}</span></p>
                        <p>- LASTNAME: <span class="popupValue">${dataTarget['lastname'].innerText}</span></p>
                        <p>- EMAIL: <span class="popupValue">${dataTarget['email'].innerText}</span></p>
                   </div>
                   <div class="confirm"> 
                       <p>Are you sure to delete from the system?</p>
                       <button id ="yesDelete" class="yesButton">Yes</button>
                       <button id ="noDelete" class="noButton">No </button>
                    </div>
                </div>
  `;
}

function deleteUserFetch(dataTarget, cell) {
    fetch("../backend/function_files/deleteUser.php", {
        method: "POST",
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify({action:'deleteUser', email: dataTarget['email'].innerText})
    })
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
            getData(1,5)
        })
        .catch(error => {
            console.error("qualcosa è andato storto", error);
        })


}