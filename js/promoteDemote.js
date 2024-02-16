function promoteDemoteUser() {
    // Come prima cosa accedo alle righe della tabelle
    // querySelectorAll restituisce una lista, in questo caso la lista di quelle che sono le righe della tabella
    var rows = document.querySelectorAll('#edituserTable tbody tr');
    const dataTarget= {
        email:null,
        firstname:null,
        lastname:null
    }
    // Per ogni riga
    rows.forEach(function(row){
        // Accedo alla cella relativa al campo roles (sapendo qual è la struttura della tabella ho fatto l'accesso tramite indice)
        var cellAdmin = row.cells[4];
        if(cellAdmin){
            // Memorizzo l'email relativa alla cella che è stata cliccata (anche in questo caso conoscendo la struttura so dove è memorizzata l'email)
            cellAdmin.addEventListener('click', function () {
                var buttons = cellAdmin.getElementsByTagName('button');
                dataTarget['email'] = row.cells[3];
                dataTarget['firstname']=row.cells[1];
                dataTarget['lastname']=row.cells[2];
                dataTarget['roles']=cellAdmin.innerText;
                popup(cellAdmin, row, dataTarget);
            });
            // Aggiungo un listener relativo al click sulla cella della tabella
            // Quando clicco -> chiamata fetch a file che faccia lo sban o il ban nel db

        }
    });

}

function appendPromoteDemoteToContainer(popUpContent, dataTarget) {
    let gridHtml = '';
    if(dataTarget['roles'] === 'Promote'){
        gridHtml += generatePromote(dataTarget);
    }
    else{
        gridHtml += generateDemote(dataTarget);
    }
    popUpContent.innerHTML = gridHtml;
}

function generatePromote(dataTarget){
    return `
        <h2>Promote</h2>
        <span id="closePopUpButton" class="close">&times;</span>
        <div>
            <p>You are promoting</p>
            <div>
                <p>- FIRSTNAME: <span class="popupValue">${dataTarget['firstname'].innerText}</span></p>
                <p>- LASTNAME: <span class="popupValue">${dataTarget['lastname'].innerText}</span></p>
                <p>- EMAIL: <span class="popupValue">${dataTarget['email'].innerText}</span></p>
            </div>
            <div class="confirm">
                <p>Are you sure?</p>
                <button id ="yesPromoteDemote" class="yesButton">Yes</button>
                <button id ="noPromoteDemote" class="noButton">No </button>
            </div>
        </div> 
    `
}

function generateDemote(dataTarget){
    return `
        <h2>Demote</h2>
        <span id="closePopUpButton" class="close">&times;</span>
        <div>
            <p>You are demoting</p>
            <div>
                <p>- FIRSTNAME: <span class="popupValue">${dataTarget['firstname'].innerText}</span></p>
                <p>- LASTNAME: <span class="popupValue">${dataTarget['lastname'].innerText}</span></p>
                <p>- EMAIL: <span class="popupValue">${dataTarget['email'].innerText}</span></p>
            </div>
            <div class="confirm">
                <p>Are you sure?</p>
                <button id ="yesPromoteDemote" class="yesButton">Yes</button>
                <button id ="noPromoteDemote" class="noButton">No </button>
            </div>
        </div> 
    `
}
function promoteDemoteFetch(dataTarget,cell){
    fetch("../backend/function_files/promoteDemoteUser.php", {
        method: "POST",
        headers: {
            'Content-type':'application/json'
        },
        body: JSON.stringify({action: 'promoteDemote', email: dataTarget['email'].innerText})
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            console.log(data);
            var promoteDemoteButton = cell.querySelector('.promoteDemoteButton');
            if(data === 1){
                promoteDemoteButton.innerHTML = 'Demote';
                promoteDemoteButton.setAttribute('data-content', 'Demote');
                promoteDemoteButton.classList.add('.promoteButton[data-content="Demote"');
            }
            else{
                promoteDemoteButton.innerHTML = 'Promote';
                promoteDemoteButton.setAttribute('data-content', 'Promote');
                promoteDemoteButton.classList.add('.promoteButton[data-content="Promote"');
            }
        })
        .catch(error => {
            console.error("Something went wrong");
        })
}