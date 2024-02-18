window.addEventListener("DOMContentLoaded", () => {
    let email=document.getElementById("email");

    let user={
        firstname:null,lastname:null,money:0,timeStudied:0,plantsPurchased:0,email:email,
    }
    console.log(user);
    dataFetch(user);
});
function dataFetch(user){
    fetch('../backend/show_profile.php', {
    method: 'POST',
    headers: {
        'Content-Type':'application/json'
    },
    body: JSON.stringify({action: 'rethriveData'})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        if (response.status === 204) { // No content
            return null;
        }
        console.log(response);
        return response.json();
    })

    .then(data => {
        console.log(data);
        user =data;
        console.log("user :", user);

        populateProfile(user);
    })
    .catch(error => {
        console.error('Error: ', error);
    });

}
function populateProfile(user){
    console.log("qui");
    var firstname= document.getElementById("firstname");
    var lastname = document.getElementById("lastname");
    var money= document.getElementById("money");
    var timestudied= document.getElementById("timestudied");
    var plantspurchased = document.getElementById("plantpurchased");
    var email=document.getElementById("email")

    firstname.innerText  = user['FIRSTNAME'];
    lastname.innerText = user['LASTNAME'];
    money.innerText = user['MONEY'];
    email.innerText=user['EMAIL'];
    if(user['TOTAL_TIME'] === null){
        timestudied.innerText = "0";
    }else{
        timestudied.innerText=user['TOTAL_TIME'].s;
    }
    plantspurchased.innerText = user['OCCURENCIESPLANT'];

}