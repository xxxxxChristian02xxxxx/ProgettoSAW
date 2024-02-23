function generateCard(plant) {
    let path = "../images/" +plant.IMG_DIR;
    return `
        <div id = '${plant.NAME}' class="card">
          <div class="card-content">
            <h2 class="card-title">${plant.NAME}</h2>
            <img src="${path}" alt="${plant.NAME}" class="card-image">
            <p class="card-price">Per unit: $${plant.PRICE}</p>
            <p id="cart-cout" class="card-price">In the cart: 0</p>
            <button class="card-buy" onclick="addFunctiontoButtons('${plant.NAME}')">ADD TO CART</button>
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
    let a = {'action':'rethriveData'}
    fetch('../backend/be_show_profile.php', {
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        body: JSON.stringify(a)
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
    document.getElementById(name).querySelector('#cart-cout').innerHTML = "In the cart: " + localStorage.getItem(name);
}

function populateAllPlants(shopContainer){
    let items = [];
    fetch("../backend/be_shop.php?flowers=1",{
        method: 'GET',
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            items = data;
            appendPlantsToContainer(items, shopContainer);
        })
        .catch(error => {
            console.error("Si è verificato un errore: ", error);
        });

}

document.getElementById('search_form').addEventListener('submit', (event) => {
    let items = [];
    event.preventDefault();
    const search = document.getElementById('search').value;
    const shopContainer = document.getElementById('shop-container');
    if (search === '') {
        alert('Empty search');
        populateAllPlants(shopContainer);
        return;
    }
    fetch(`../backend/be_shop.php?search=${search}`,{
        method: 'GET',
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            items = data;
            if (items.length === 0) {
                alert('No items found');
                populateAllPlants(shopContainer);
            }else{
                appendPlantsToContainer(items, shopContainer);
            }

        })
        .catch(error => {
            console.error("Si è verificato un errore: ", error);
        });
});




