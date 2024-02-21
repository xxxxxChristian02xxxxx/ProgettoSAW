window.addEventListener("DOMContentLoaded", () => {
    let email=document.getElementById("email");

    let user={
        firstname:null,lastname:null,money:0,timeStudied:0,plantsPurchased:0,email:email,
    }
    dataFetch(user);
});
function dataFetch(user){
    fetch('../backend/be_show_profile.php', {
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
        return response.json();
    })

    .then(data => {
        user =data;

        populateProfile(user);
    })
    .catch(error => {
        console.error('Error: ', error);
    });

}
function populateProfile(user){
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
    //user['TOTAL_TIME']=0;
    if(user['TOTAL_TIME'] === null){
        timestudied.innerText = "0";
    }else{
        displayTime(user['TOTAL_TIME'],timestudied);
    }
    plantspurchased.innerText = user['OCCURENCIESPLANT'];
}
function displayTime(time,timestudied){
    let formattedTime;
    let hours = Math.floor(time / 3600);
    let remainingSeconds = time % 3600;
    let minutes = Math.floor(remainingSeconds / 60);
    let seconds = remainingSeconds % 60;
    if (hours) {
        formattedTime = hours + "h " + minutes + "m " + seconds + "s";
    } else {
        formattedTime = minutes + "m " + seconds + "s";
    }
    timestudied.innerText = formattedTime;



}


