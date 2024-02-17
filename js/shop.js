function generateCard(plant) {
    let path = "../images/" +plant.IMG_DIR;
    return `
        <div id = '${plant.NAME}' class="card">
          <div class="card-content">
            <h2 class="card-title">${plant.NAME}</h2>
            <img src="${path}" alt="${plant.NAME}" class="card-image">
            <p class="card-price">Per unit: $${plant.PRICE}</p>
            <button class="card-buy" onclick="addFunctiontoButtons('${plant.NAME}')"> BUY</button>
          </div>
        </div> 
  `;
}

function appendPlantsToContainer(plants, container) {
    let gridHtml = '';
    plants.forEach(plant => {
        gridHtml += generateCard(plant);
    });
    container.innerHTML = gridHtml;
}

function getMoney(){
    fetch('../backend/be_myprofile.php', {
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        body: JSON.stringify({action: 'requestProfileData'})
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
               document.getElementById('MyMoney').innerHTML = data['MONEY'];
        })
        .catch(error => {
            console.error('Error: ', error);
        });
}

function addFunctiontoButtons(name) {
    if(localStorage.hasOwnProperty(name)) {
        localStorage.setItem(name, parseInt(localStorage.getItem(name)) + 1);
    }else{
        localStorage.setItem(name, '1');
    }
}

function appendCarttoContainer(popUpContent){
    let gridHtml = '';
    gridHtml += generateCart();
    popUpContent.innerHTML = gridHtml;
}

function generateCart(){
    let text = `
    <h2>Cart</h2>
    <span id="closePopUpButton" className="close">&times;</span>
    <div>
        <p>This is your actual cart:</p>
       `;
    for (let i = 0; i < localStorage.length; i++){
        let key = localStorage.key(i);
        let value = localStorage.getItem(key);
        text += `
        <div>
            <p>- ${key} : ${value}</p>
        </div>
        `;
    }
    text += `<div class="confirm">
        <p>Are you sure to delete from the system?</p>
        <button id ="yesDelete" class="yesButton">Yes</button>
        <button id ="noDelete" class="noButton">No </button>
    </div>
    </div>`
    return text;
}