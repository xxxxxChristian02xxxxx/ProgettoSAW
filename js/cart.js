const table = document.querySelector('#cartTable tbody')
let id = 0;
function setMoney(plants) {
    return fetch('../backend/be_show_profile.php', {
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        body: JSON.stringify({'action':'rethriveData'})
    })
        .then(response =>
            response.json())
        .then(data => {
            console.log(plants);
            document.getElementById('yourMoney').innerHTML = 'Total money: ' + data['MONEY'];
            id = data['ID']
            let cart = [];
            let dat = JSON.parse(localStorage.getItem(id))
            for (let i = 0; i < plants.length; i++){
                console.log(plants[i]['NAME'])
                if(dat.hasOwnProperty(plants[i].NAME)){
                    $price = parseInt(plants[i].PRICE) * parseInt(dat[plants[i].NAME]);
                    cart.push([plants[i].NAME, dat[plants[i].NAME], $price, plants[i].PLANTS_ID] );
                }
            }
            document.getElementById('totalPrice').innerHTML = 'Total price: '+ dat['total_price'] ?? 0;
            console.log(cart)
            populatecartTable(cart)
            createbuyButton(cart,data['total_price'] ?? 0, data['MONEY'])
        })
        .catch(error => {
            console.error('Error: ', error);
        });
}
document.addEventListener('DOMContentLoaded', function () {
    getData();
    document.getElementById('empty').addEventListener('click', () => {
        localStorage.removeItem(id);
        alert("Cart emptied");
        location.reload();
    });
});
function createbuyButton(cart, totalprice, money) {
    document.getElementById('buy').addEventListener('click', () => {
            fetch("../backend/be_shop.php?buy=1", {
                method: 'POST',
                body: JSON.stringify({carts: cart, money: money}),
            })
                .then(response => {
                    return response.text();
                })
                .then(data => {
                    alert("Purchase completed");
                    localStorage.removeItem(id);
                    location.reload();
                })
                .catch(error => {
                    console.error("Error: ", error);
                });

    });
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
            return setMoney(plants);
        })
        .catch(error => {
            console.error("Si è verificato un errore: ", error);
        });
}
function populatecartTable(cart){
    table.innerHTML = '';
    for (let key in cart) {
        let newRow = document.createElement('tr');
        let newCell;
        for(let i = 0; i < 3; i++){
            newCell = document.createElement('td');
            newCell.textContent = cart[key][i];
            newRow.appendChild(newCell)
        }
        newCell = document.createElement('td');
        var lessButton = document.createElement('button');
        lessButton.innerHTML = '-';
        lessButton.className = "lessButton";

        lessButton.addEventListener('click', () => {
            let data = JSON.parse(localStorage.getItem(id))
            let $single = cart[key][2]/cart[key][1]
            if(data[cart[key][0]] > 1){
                data[cart[key][0]] =  parseInt(data[cart[key][0]]) - 1;
                location.reload();
            }else{
                delete data[cart[key][0]]

                location.reload();
            }
            data['total_price'] = parseInt((data['total_price']) - parseInt($single))
            localStorage.setItem(id,JSON.stringify(data))
        });

        newCell.appendChild(lessButton);
        newRow.appendChild(newCell);
        table.appendChild(newRow);
    }
}