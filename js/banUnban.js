function banUnban() {
    var rows = document.querySelectorAll('#edituserTable tbody tr');
    var dataTarget= {
        email:null,
        firstname:null,
        lastname:null,
        banned:null
    }

    rows.forEach(function(row){
        var cellBan = row.cells[5];
        if(cellBan){
            cellBan.addEventListener('click', function () {
                dataTarget['email'] = row.cells[3];
                dataTarget['firstname']=row.cells[1];
                dataTarget['lastname']=row.cells[2];
                dataTarget['banned']=cellBan.innerText;
                popup(cellBan,row,dataTarget);
            });
        }
    });
}

function appendBanUnabanToContainer(popUpContent, dataTarget) {
    let gridHtml = '';
    if(dataTarget['banned'] === 'Ban'){
        gridHtml += generateBan(dataTarget);
    }
    else{
        gridHtml += generateUnban(dataTarget);
    }
    popUpContent.innerHTML = gridHtml;
}

function generateBan(dataTarget) {
    return `
        <h2>Ban</h2>
                <span id="closePopUpButton" class="close">&times;</span>
                <div>
                   <p> You are banning</p>
                   <div>
                        <p>- FIRSTNAME: <span class="popupValue">${dataTarget['firstname'].innerText}</span></p>
                        <p>- LASTNAME: <span class="popupValue">${dataTarget['lastname'].innerText}</span></p>
                        <p>- EMAIL: <span class="popupValue">${dataTarget['email'].innerText}</span></p>
                   </div> 
                   <div id="confirm">
                      <p>Are you sure?</p>
                      <button id ="yesBanUnban" class="yesButton">Yes</button>
                      <button id ="noBanUnban" class="noButton">No</button>
                   </div>
                </div>
  `;
}

function generateUnban(dataTarget) {
    return `
        <h2>Unban</h2>
                <span id="closePopUpButton" class="close">&times;</span>
                <div>
                   <p> You are unbanning</p>
                   <div>
                        <p>- FIRSTNAME: <span class="popupValue">${dataTarget['firstname'].innerText}</span></p>
                        <p>- LASTNAME: <span class="popupValue">${dataTarget['lastname'].innerText}</span></p>
                        <p>- EMAIL: <span class="popupValue">${dataTarget['email'].innerText}</span></p>
                   </div> 
                   <div id="confirm">
                      <p>Are you sure?</p>
                      <button id ="yesBanUnban" class="yesButton">Yes</button>
                      <button id ="noBanUnban" class="noButton">No</button>
                   </div>
                </div>
  `;
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
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) { // No content
                return null;
            }
            return response.json();
        })
        .then(data => {
            var banUnbanButton = cell.querySelector('.banUnbanButton');
            if(data['BANNED'] === 1){
                banUnbanButton.innerHTML = 'Unban';
                banUnbanButton.setAttribute('data-content', 'Unban');
                banUnbanButton.classList.add('.banUnbanButton[data-content="Unban"');
            }
            else{
                banUnbanButton.innerHTML = 'Ban';
                banUnbanButton.setAttribute('data-content', 'Ban');
                banUnbanButton.classList.add('.banUnbanButton[data-content="Ban"');
            }
        })
        .catch(error => {
            console.error("Something went wrong", error);
        });
}