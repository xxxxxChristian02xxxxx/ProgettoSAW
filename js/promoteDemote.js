function promoteDemoteUser() {
    var rows = document.querySelectorAll('#edituserTable tbody tr');

    let dataTarget= {
        email:null,
        firstname:null,
        lastname:null
    }

    rows.forEach(function(row){
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
            <div id="confirm">
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
            <div id="confirm">
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
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) { // No content
                return null;
            }
            return response.json();        })
        .then(data => {
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
            console.error("Something went wrong", error);
        })
}