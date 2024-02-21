const table = document.querySelector('#cartTable tbody')
function setMoney() {
    return fetch('../backend/be_show_profile.php', {
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        body: JSON.stringify({'action':'rethriveData'})
    })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.getElementById('yourMoney').innerHTML = 'Total money: ' + data['MONEY'];
            return data['MONEY'];
        })
        .catch(error => {
            console.error('Error: ', error);
        });
}

document.addEventListener('DOMContentLoaded', function () {
    // Si ottengono i dati
    console.log("ciao");
    getData();

    console.log("testiong");
    document.getElementById('empty').addEventListener('click', () => {
        localStorage.clear();
        alert("Cart emptied");
        location.reload();
    });
});

function createbuyButton(cart, money) {
    document.getElementById('buy').addEventListener('click', () => {

            fetch("../backend/be_shop.php?buy=1", {
                method: 'POST',
                body: JSON.stringify({carts: cart, money: money}),
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
                    console.log(data['cart']);
                    alert(data['cart']);
                    localStorage.clear();
                    location.reload();
                })
                .catch(error => {
                    console.error("Vengo qua: ", error);
                });
    });
}

function createCart(plants) {
    const money = setMoney();
    let totalprice = 0;
    let cart = [];
    console.log(plants)
    console.log(localStorage);
    for (let i = 0; i < plants.length; i++){
        if(localStorage.hasOwnProperty(plants[i].NAME)){
            $price = plants[i].PRICE * localStorage.getItem(plants[i].NAME);
            cart.push([plants[i].NAME, localStorage.getItem(plants[i].NAME), $price, plants[i].PLANTS_ID] );
            totalprice += $price;
        }
    }
    document.getElementById('totalPrice').innerHTML = 'Total price: ' + totalprice;
    console.log(cart);
    populatecartTable(cart);
    createbuyButton(cart, money);
    return totalprice;
}

function getData(){
    let plants = [];

    fetch("../backend/be_shop.php?flowers=1",{
        method: 'GET',
    })
        .then(response => {
            return response.json();
        })
        .then(data => {
            plants = data;
            return createCart(plants);
        })
        .catch(error => {
            console.error("Si è verificato un errore: ", error);
        });
}
function populatecartTable(cart){
    console.log('sto popolando la tabella');
    table.innerHTML = '';
    for (let key in cart) {
        let newRow = document.createElement('tr');
        for(var i=0; i<3; i++){
            let newCell = document.createElement('td');
            newCell.textContent = cart[key][i];
            newRow.appendChild(newCell);
        }
        table.appendChild(newRow);
    }
}