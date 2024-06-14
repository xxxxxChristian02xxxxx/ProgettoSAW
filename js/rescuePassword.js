window.addEventListener("DOMContentLoaded", () => {
    document.getElementById('UserRescuePassword').addEventListener('submit', function(event) {
        event.preventDefault();
        var email = document.getElementById("email").value;
            var password= document.getElementById("pass").value;
            var confirmPass= document.getElementById("confirm").value;
            if(password === confirmPass){
                mailFetch(confirmPass,email);
            }
    })
})

function mailFetch(confirmPass,email){
    fetch('../backend/function_files/forgottenPasswordLogin.php', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json',
        },
        body: JSON.stringify({email: email, action:'checkPresenceEmail' }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) {
                return null;
            }
            return response.json();
     })
        .then(data => {
            if(data['present']) {
                popup(email,confirmPass);
            }else{
                let emailError = document.getElementById("emailErro");
                emailError.classList.remove("errore")
            }
        })
        .catch(error => {
            console.error('Si è verificato un errore durante la fetch:', error);
        })
}
function passwordFetch(email,confiermPass){
    fetch('../backend/function_files/forgottenPasswordLogin.php', {
        method: 'POST',
        headers: {
            'Content-type': 'application/json',
        },
        body: JSON.stringify({email:email, password:confiermPass, action: 'updatePasswordLogin' }),
    })
        .catch(error => {
            console.error('Si è verificato un errore durante la fetch:', error);
        })
}
function generateRandom(values){
    values[0]= Math.floor(Math.random() * 100).toString();
    values[1]= Math.floor(Math.random() * 100).toString();
    values[2]= Math.floor(Math.random() * 100).toString();
    while (values[0] === values[1] || values[0] === values[2]) {
        values[0] = Math.floor(Math.random() * 4);
    }
    while (values[1] === values[2]) {
        values[1] = Math.floor(Math.random() * 4);
    }
    var randomNumber = Math.floor(Math.random() * 3);
    var numTarget  =values[randomNumber];
    console.log("key:",numTarget);
    return numTarget
}
function isTarget(num, numTarget,email,confiermPass,popUp){
    const changeSucceeded = document.getElementById('changeSucceeded');
    const cometologin1 = document.getElementById('cometologin1');
    const changeNotSuceeded = document.getElementById('changeNotSuceeded');
    const cometologin2 = document.getElementById('cometologin2');
    const againRandom = document.getElementById('againRandom');
    const buttonChoise = document.getElementById('buttonChoise');
    buttonChoise.classList.add("hidden");

        if (num === numTarget) {
            changeNotSuceeded.classList.add("hidden");
            passwordFetch(email, confiermPass);
            changeSucceeded.classList.remove("hidden");
            cometologin1.addEventListener("click", () => {
                popUp.classList.add('hidden');
                document.body.style.overflow = 'auto';
                window.location.replace("login.php")
                changeSucceeded.classList.add("hidden");
                buttonChoise.classList.remove("hidden");
            })
        } else {
            changeNotSuceeded.classList.remove("hidden");

            cometologin2.addEventListener("click", () => {
                popUp.classList.add('hidden');
                document.body.style.overflow = 'auto';
                window.location.replace("login.php")
                changeSucceeded.classList.add("hidden");
                buttonChoise.classList.remove("hidden");
            })
            againRandom.addEventListener("click", () => {
                changeNotSuceeded.classList.add("hidden");
                buttonChoise.classList.remove("hidden");
                popup(email,confiermPass);

            })
        }

}
function popUpManager(email,confiermPass,popUp,popUpContent){
    const changeNotSuceeded = document.getElementById('changeNotSuceeded');
    changeNotSuceeded.classList.add("hidden");

    const closePopUpButton = document.getElementById('closePopUpButton');
    const option1 =document.getElementById("option1");
    const option2 =document.getElementById("option2");
    const option3 =document.getElementById("option3");
    let values = [];
    let numTarget = generateRandom(values);

    option1.innerText = values[0].toString();
    option2.innerText = values[1].toString();
    option3.innerText = values[2].toString();

    option1.addEventListener('click',  () => {
        isTarget(values[0], numTarget, email, confiermPass, popUp, popUpContent);
    })
    option2.addEventListener('click', () => {
        isTarget(values[1], numTarget, email, confiermPass, popUp, popUpContent);

    });
    option3.addEventListener('click', () => {
       isTarget(values[2], numTarget, email, confiermPass, popUp, popUpContent);

    });
    closePopUpButton.addEventListener('click', () => {
        popUp.classList.add('hidden');
        document.body.style.overflow = 'auto';
    });
    popUp.addEventListener('click', (event) => {
        if (event.target === popUp) {
        } else if (event.target.closest('#modalContent') === null) {
            popUp.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });
    popUpContent.addEventListener('click', (event) => {
        event.stopPropagation();
    });

}
function popup(email,confiermPass) {
    const popUp = document.getElementById('popUp');
    const popUpContent = document.getElementById('popUpContent');
    if (popUp && popUpContent) {
        popUp.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        appendPasswordModify(popUpContent, email);
        popUpManager(email,confiermPass,popUp,popUpContent);
    }
}
function appendPasswordModify(popUpContent, email) {
    let gridHtml = '';
    gridHtml += generatePasswordModify(email);
    popUpContent.innerHTML = gridHtml;
}
function generatePasswordModify(email) {
    return `
        <h2>Check your email to proceed</h2>
                <span id="closePopUpButton" class="close">&times;</span>
                <div>
                    <p >Your email : ${email} <p>
                </div>
                <div>
                    <p >An e-mail has been sent to you, just click the number you see on your mail to proceed <p>
                </div>
                <div class="displayFirst" id="buttonChoise">
                    <button class="circle-button" id ="option1"></button>
                    <button class="circle-button" id ="option2"></button>
                    <button class="circle-button" id ="option3"></button>
                </div>
                <div class="hidden" id ="changeSucceeded">
                    <p> The password has been changed successfully </p>
                    <div>
                        <button id="cometologin1"> Come back to Login </button>
                    </div>
                </div>
                <div class="hidden" id ="changeNotSuceeded">
                    <p> The number you chose is not the validation number </p>
                    <div>
                        <button id="cometologin2"> Come back to Login </button>
                        <button id="againRandom"> Resend validation number </button>
                    </div>
                </div>
  `
}
