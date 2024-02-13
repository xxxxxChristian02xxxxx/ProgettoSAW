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
            modifyMoney();
            promoteDemoteUser();
            deleteUser();
        })
        .catch(error => console.error('Error in reaching data:', error));
}

// Funzione per cambiare il ruolo di un utente
function banUnban() {
    // Come prima cosa accedo alle righe della tabelle
    // querySelectorAll restituisce una lista, in questo caso la lista di quelle che sono le righe della tabella
    var rows = document.querySelectorAll('#edituserTable tbody tr');
    const dataTarget= {
        email:null,
        firstname:null,
        lastname:null,
    }
    // Per ogni riga
    rows.forEach(function(row){
        // Accedo alla cella relativa al campo ban (sapendo qual è la struttura della tabella ho fatto l'accesso tramite indice)
        var cellBan = row.cells[6];
        if(cellBan){
            // Memorizzo l'email relativa alla cella che è stata cliccata (anche in questo caso conoscendo la struttura so dove è memorizzata l'email)
            cellBan.addEventListener('click', function () {
                dataTarget['email'] = row.cells[3];
                dataTarget['firstname']=row.cells[1];
                dataTarget['lastname']=row.cells[2];
                console.log("o",dataTarget);
                popup(cellBan,row,dataTarget);
            });
            // Aggiungo un listener relativo al click sulla cella della tabella
            // Quando clicco -> chiamata fetch a file che faccia lo sban o il ban nel db

        }
    });

}

function promoteDemoteUser() {
    // Come prima cosa accedo alle righe della tabelle
    // querySelectorAll restituisce una lista, in questo caso la lista di quelle che sono le righe della tabella
    var rows = document.querySelectorAll('#edituserTable tbody tr');
    const dataTarget= {
        email:null,
        firstname:null,
        lastname:null,
    }
    // Per ogni riga
    rows.forEach(function(row){
        // Accedo alla cella relativa al campo roles (sapendo qual è la struttura della tabella ho fatto l'accesso tramite indice)
        var cellAdmin = row.cells[5];
        if(cellAdmin){
            // Memorizzo l'email relativa alla cella che è stata cliccata (anche in questo caso conoscendo la struttura so dove è memorizzata l'email)
            cellAdmin.addEventListener('click', function () {
                dataTarget['email'] = row.cells[3];
                dataTarget['firstname']=row.cells[1];
                dataTarget['lastname']=row.cells[2];

                promoteDemoteFetch(dataTarget, cellAdmin);
            });
            // Aggiungo un listener relativo al click sulla cella della tabella
            // Quando clicco -> chiamata fetch a file che faccia lo sban o il ban nel db

        }
    });

}
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
        // Accedo alla cella relativa al campo ban (sapendo qual è la struttura della tabella ho fatto l'accesso tramite indice)

        var cell = row.cells[10];
        if (cell) {
            // Memorizzo l'email relativa alla cella che è stata cliccata (anche in questo caso conoscendo la struttura so dove è memorizzata l'email)
            cell.addEventListener('click', function () {
                dataTarget['email'] = row.cells[3];
                popup(cell, row, dataTarget);
            });
        }
    });
}

function deleteUser() {
    var rows = document.querySelectorAll('#edituserTable tbody tr');
    const dataTarget = {
        email: null,
    }
    // Per ogni riga
    rows.forEach(function (row) {
        // Accedo alla cella relativa al campo ban (sapendo qual è la struttura della tabella ho fatto l'accesso tramite indice)
        var cell = row.cells[11];
        if (cell) {
            // Memorizzo l'email relativa alla cella che è stata cliccata (anche in questo caso conoscendo la struttura so dove è memorizzata l'email)
            cell.addEventListener('click', function () {
                dataTarget['email'] = row.cells[3];
                popup(cell, row, dataTarget);
            });

        }
    });
}

function popup(cell, row, dataTarget) {
    const popUp = document.getElementById('popUp');
    const popUpContent = document.getElementById('popUpContent');
    if (popUp && popUpContent) {
        popUp.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        switch (cell) {
            case row.cells[6]:
                console.log("6", dataTarget)
                appendBanUnabanToContainer(popUpContent, dataTarget)
                break;
            case row.cells[10]:
                console.log("10")
                appendModifyToContainer(popUpContent, cell)
                break;
            case row.cells[11]:
                console.log("11", dataTarget);
                appendDeleteToContainer(popUpContent, dataTarget);
        }
        const closePopUpButton = document.getElementById('closePopUpButton');
        switch (cell) {
            case row.cells[6]:
                const saidYes = document.getElementById("sheSaidYes");
                const saidNo = document.getElementById("sheSaidNo");

                saidYes.addEventListener('click', () => {
                    banUnbanFetch(dataTarget, cell);
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });

                saidNo.addEventListener('click', () => {
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
                break;
            case row.cells[10]:
                const modifyAmount = document.getElementById("modifymount");
                const changeMoney = document.getElementById("changeMoney");
                const space = document.getElementById("alertspace");
                const resetMoney = document.getElementById("resetAmount")
                var isnum = null;
                var num;

                modifyAmount.addEventListener("input", () => {
                    console.log(num);
                    num = modifyAmount.value;

                    const regex = /^\d+$/;
                    if (regex.test(num)) {
                        console.log("integer");
                        isnum = true;
                    } else {
                        isnum = false;
                        if (num.includes(" ")) {
                            console.log("space");
                            space.classList.remove('hidden');
                            space.style.color = "red";
                        } else {
                            space.classList.add('hidden');
                        }
                    }
                })
                changeMoney.addEventListener("click", () => {
                    if (isnum) {
                        dataTarget['operation'] = 1;
                        dataTarget['money'] = num;
                        modifyFetch(dataTarget, cell);
                        popUp.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    } else {
                        alert("not valied amount");

                    }
                })
                resetMoney.addEventListener("click", (event) => {

                    if (resetMoney.style.borderColor === "red") {
                        dataTarget['operation'] = 2;
                        resetMoney.style.borderColor = "black";
                        modifyFetch(dataTarget, cell);
                        popUp.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    } else {
                        resetMoney.style.borderColor = "red";
                    }
                });
                break;
            case row.cells[11]:
                const votedYes = document.getElementById("yesDelete");
                const votedNo = document.getElementById("noDelete");

                votedYes.addEventListener('click', () => {
                    deleteUserFetch(dataTarget, cell);
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });

                votedNo.addEventListener('click', () => {
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                });
                break;

        }

        closePopUpButton.addEventListener('click', () => {
            popUp.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });

        popUp.addEventListener('click', (event) => {
            if (event.target === popUp) {
            } else if (event.target.closest('#modalContent') === null) {
                popUp.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });

        popUpContent.addEventListener('click', (event) => {
            event.stopPropagation();
        });
    }
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
             response.json()
        )
        .then(data => {
            console.log(data);
            cell.innerText = data;

        })
        .catch(error => {
            console.error("qualcosa è andato storto", error);
        })


}

function banUnbanFetch(dataTarget, cell) {
    fetch("../backend/function_files/banUnban.php", {
        method: "POST",
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify({action: 'banUnban', email: dataTarget['email'].innerText})
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            console.log(data);
            cell.innerText = data;
        })
        .catch(error => {
            console.error("qualcosa è andato storto");
        })
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
            var promoteButton = cell.querySelector('.promoteButton');
            if(data === 1){
                promoteButton.innerHTML = 'Demote';
                promoteButton.setAttribute('data-content', 'Demote');
                promoteButton.classList.add('.promoteButton[data-content="Demote"');
            }
            else{
                promoteButton.innerHTML = 'Promote';
                promoteButton.setAttribute('data-content', 'Promote');
                promoteButton.classList.add('.promoteButton[data-content="Promote"');
            }
        })
        .catch(error => {
            console.error("qualcosa è andato storto");
        })
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
                    <label for ="modifymount">Insert Amount</label>
                    <span><input type="text" id="modifymount"></span>
                    <button id ="changeMoney">Change Money</button>
                    <span><p id="alertspace" class="hidden" > there is a space </p></span>

                </div>
                <div>
                    <p>
                    <button id ="resetAmount">Reset Money</button>
                    </p>
                </div>
  `
}

function generateDelete(dataTarget) {
    return `
        <h2> Delete User </h2>
                <span id="closePopUpButton" class="close">&times;</span>
                <div>
                   <p> You are deleting </p>
                   <div>
                        <p>-email: ${dataTarget['email'].innerText}</p>
                    </div> 
                   <p>Are you sure to delete from the system?</p>
                <div>
                     <button id ="yesDelete">Yes</button>
                     <button id ="noDelete">No </button>

                </div>
                </div>
  `;
}

function appendDeleteToContainer(popUpContent, dataTarget) {
    let gridHtml = '';
    gridHtml += generateDelete(dataTarget);
    popUpContent.innerHTML = gridHtml;
}

function appendBanUnabanToContainer(popUpContent, dataTarget) {
    let gridHtml = '';
    gridHtml += generateBanUnban(dataTarget);
    popUpContent.innerHTML = gridHtml;
}

function generateBanUnban(dataTarget) {
    console.log("b");
    return `
        <h2>Ban / Unban </h2>
                <span id="closePopUpButton" class="close">&times;</span>
                <div>
                   <p> You are banning</p>
                   <div>
                        <p>-firtname: ${dataTarget['firstname'].innerText}</p>
                        <p>-lastname: ${dataTarget['lastname'].innerText}</p>
                        <p>-email: ${dataTarget['email'].innerText}</p>
                    </div> 
                   <p>Are you sure?</p>
                <div>
                     <button id ="sheSaidYes">Yes</button>
                     <button id ="sheSaidNo">No </button>

                </div>
                </div>
  `;
}

function deleteUserFetch(dataTarget, cell) {
    fetch("../backend/function_files/banUnban.php", {
        method: "POST",
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify({action: 'deleteUser', email: dataTarget['email'].innerText})
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            console.log(data);
            cell.innerText = data;
        })
        .catch(error => {
            console.error("qualcosa è andato storto", error);
        })


}