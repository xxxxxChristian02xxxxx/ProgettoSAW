function modifyMoney() {
    // Come prima cosa accedo alle righe della tabelle
    // querySelectorAll restituisce una lista, in questo caso la lista di quelle che sono le righe della tabella
    var rows = document.querySelectorAll('#edituserTable tbody tr');
    const dataTarget = {
        email: null,
        money: null,
        operation: null

    }
    // Per ogni riga
    rows.forEach(function (row) {
        // Accedo alla cella relativa al campo money (sapendo qual è la struttura della tabella ho fatto l'accesso tramite indice)
        var cell = row.cells[6];
        if (cell) {
            // Memorizzo l'email relativa alla cella che è stata cliccata (anche in questo caso conoscendo la struttura so dove è memorizzata l'email)
            cell.addEventListener('click', function () {
                dataTarget['email'] = row.cells[3];
                popup(cell, row, dataTarget);
            });
        }
    });
}

function appendModifyToContainer(popUpContent,cell) {
    let gridHtml = '';
    gridHtml += generateModify(cell);
    popUpContent.innerHTML = gridHtml;
}

function generateModify(cell) {
    console.log("p");
    return `
        <h2>Modify Money</h2>
                <span id="closePopUpButton" class="close">&times;</span>
                <div>
                    <p id ="displayCurrenMoney">Current Amount : $${cell.innerText}  <span><p id="currentMoney"></p></span>
                </div>
                <div>
                    <label for ="modifymount">Insert Amount:</label>
                    <input type="text" id="modifymount">
                    <button id="changeMoney">Change Money</button>
                </div>
                <div>
                    <button id ="resetAmount">Reset Money</button>
                </div>
  `
}

function modifyFetch(dataTarget, cell) {
    let Action;
    switch (dataTarget['operation']) {
        case 2:
            Action = "resetMoney";
            break;
        case 1:
            Action = "modifyMoney";
            break;
    }

    fetch("../backend/function_files/modifyMoney.php", {
        method: "POST",
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify({action: Action, email: dataTarget['email'].innerText, money: dataTarget['money']})
    })
        .then(response =>
            //console.log("Response: ", response); // log the response
            //return response.text();
        {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) { // No content
                return null;
            }
            return response.json();
        }        )
        .then(data => {
            console.log(data);
            cell.innerText = data;

        })
        .catch(error => {
            console.error("qualcosa è andato storto", error);
        })


}