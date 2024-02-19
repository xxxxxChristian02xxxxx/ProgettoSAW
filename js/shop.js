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
            return data['MONEY'];
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    return 0;

}

function addFunctiontoButtons(name) {
    if(localStorage.hasOwnProperty(name)) {
        localStorage.setItem(name, parseInt(localStorage.getItem(name)) + 1);
    }else{
        localStorage.setItem(name, '1');
    }
}

function appendCarttoContainer(popUpContent, items, money){
    let gridHtml = '';
    gridHtml += `<h2>Cart</h2>
    <span id="closePopUpButton" className="close">&times;</span>
    <div>
    <div>
        <p>This is your actual cart:</p>
        `;
   let cart = generateCart(items, money);
    if(cart === 0){
        gridHtml += `</div>
        <div class="confirm">
        <p>YOU DON'T HAVE ENOUGH MONEY</p>
        </div>
       </div>`;
        popUpContent.innerHTML = gridHtml;
        return 0;
    }
    for (let key in cart) {
        gridHtml += `<p>${key} : ${cart[key]}</p>`;
    }
    gridHtml += `</div>
        <div class="confirm">
        <p>Are you sure?</p>
        <button id ="yesCart" class="yesButton">Yes</button>
        <button id ="noCart" class="noButton">No</button>
        </div>
       </div>`;
    popUpContent.innerHTML = gridHtml;
    return cart;
}

function generateCart(plants, money){
    let cart = {};
    let total = 0;
    for (let i = 0; i < plants.length; i++){
        if(localStorage.hasOwnProperty(plants[i].NAME)){
            cart[plants[i].NAME] = localStorage.getItem(plants[i].NAME);
            total += plants[i].PRICE * localStorage.getItem(plants[i].NAME);
        }
    }
    if(total > money){
        alert('You do not have enough money');
        return 0;
    }
    console.log(cart);
    return cart;
}

function buyFetch(cart){
    fetch("../backend/be_shop.php", {
        method: "POST",
        headers: {
            'Content-type': 'application/json'
        },
        body: JSON.stringify({action: 'buy', cart: cart})
    })
        .then(response => {
            console.log(response);
        })
        .catch(error => {
            console.error('Error: ', error);
        });

}
