function modifyMoney() {
    var rows = document.querySelectorAll('#edituserTable tbody tr');
    const dataTarget = {
        email: null,
        money: null,
        operation: null
    }

    rows.forEach(function (row) {
        var cell = row.cells[6];
        if (cell) {
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
    return `
        <h2>Modify Money</h2>
                <span id="closePopUpButton" class="close">&times;</span>
                <div>
                    <p id ="displayCurrenMoney">Current Amount : $${cell.innerText} </p>
                </div>
                <div>
                    <label for ="modifymount">Insert Amount:</label>
                    <input type="text" id="modifymount">
                    <p id="alertspace" class="hidden">no space allowed</p>
                    <button id="changeMoney">Change Money</button>
                </div>
                <div>
                    <button id ="resetAmount">Reset Money</button>
                </div>
                <div id="confirm" class="hidden"> 
                       <p>Are you sure you want to modify the money count?</p>
                       <button id ="yesChange" class="yesButton">Yes</button>
                       <button id ="noChange" class="noButton">No </button>
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
        {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) { // No content
                return null;
            }
            return response.json();
        })
        .then(data => {
            cell.innerText = data;
        })
        .catch(error => {
            console.error("qualcosa è andato storto", error);
        })


}