let items = [];
let id = 0;
window.addEventListener('load', () => {
    const shopContainer = document.getElementById('shop-container');


    getMoney(shopContainer);


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
});


function generateCard(plant) {
    let num = 0;
    if(JSON.parse(localStorage.getItem(id)).hasOwnProperty(plant.NAME)) {
         num = JSON.parse(localStorage.getItem(id))[plant.NAME]
    }
    let path = "../images/" +plant.IMG_DIR;
    return `
        <div id = '${plant.NAME}' class="card">
          <div class="card-content">
            <h2 class="card-title">${plant.NAME}</h2>
            <img src="${path}" alt="${plant.NAME}" class="card-image">
            <p class="card-price">Per unit: $${plant.PRICE}</p>
            <p id="cart-cout" class="card-price">In the cart: ${num} </p> 
            <button class="card-buy" onclick="addFunctiontoButtons('${plant.NAME}', '${plant.PRICE}')">ADD TO CART</button>
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

function setMoneyInLocal(id, money) {
    let data;
    if (localStorage.getItem(id) == null) {
        data = {
            'money': money
        }
    } else {
        data = JSON.parse(localStorage.getItem(id))
        data['money'] = money

    }
    localStorage.setItem(id, JSON.stringify(data))
}

function getMoney(shopContainer){
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

            document.getElementById('MyMoney').innerHTML = data['MONEY'];
            id = data['ID'];
            setMoneyInLocal(data['ID'],data['MONEY']);
            populateAllPlants(shopContainer);
            return data['MONEY'];
        })
        .catch(error => {
            console.error('Error: ', error);
        });
    return 0;

}

function addFunctiontoButtons(name, price) {

    let data = JSON.parse(localStorage.getItem(id))
    console.log(data)
    if(parseInt(price) <= parseInt(data['money']) - parseInt(data['total_price'] ?? 0)) {
        data['total_price'] = parseInt((data['total_price'] ?? 0) + parseInt(price))
        if (data.hasOwnProperty(name)) {
            data[name] = parseInt(data[name]) + 1

        } else {
            data[name] = 1;
        }
        document.getElementById(name).querySelector('#cart-cout').innerHTML = "In the cart: " + data[name];
        localStorage.setItem(id, JSON.stringify(data))
    }else{
        alert("You dont have enough money")
    }
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






