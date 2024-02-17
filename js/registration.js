document.getElementById('UserRegistration').addEventListener('submit', function (event) {

    event.preventDefault();
    validateInput();
    const formData = {
        firstname: document.getElementById('firstname').value,
        lastname: document.getElementById('lastname').value,
        email: document.getElementById('email').value,
        pass: document.getElementById('pass').value,
        confirm: document.getElementById('confirm').value,
    };
    console.log(formData);
    //chimata dal frontend login in backend login
    fetchRegistration(formData);
});


function validateInput() {

    // Recupero dei valori inseriti in input
    const firstname = document.getElementById('firstname').value;
    const lastname = document.getElementById('lastname').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('pass').value;
    const confirm = document.getElementById('confirm').value;


    if (firstname === '') {
        document.getElementById('firstnameError').innerHTML = 'Il campo firstname è obbligatorio';
    } else {
        document.getElementById('firstnameError').innerHTML = '';
    }

    if (lastname === '') {
        document.getElementById('lastnameError').innerHTML = 'Il campo lastname è obbligatorio';
    } else {
        document.getElementById('lastnameError').innerHTML = '';
    }

    if (email === '') {
        document.getElementById('emailError').innerHTML = 'Il campo email è obbligatorio';
    } else {
        document.getElementById('emailError').innerHTML = '';
    }

    if (password !== '' && confirm !== '') {
        if (password !== confirm) {
            alert('Passwords do not match');
            return false;
        }
    } else {
        document.getElementById('confirmError').innerHTML = 'I campi password e confirm è obbligatori';
    }

    const errorMessage = document.querySelectorAll('.error');
    for (let i = 0; i < errorMessage.length; i++) {
        if (errorMessage[i].innerHTML !== '') {
            return;
        }
    }
}
function fetchRegistration(formData){
    fetch('../backend/be_registration.php', { // dico il percorso del file di back end
        method: 'POST', //metodo get o post
        headers: {
            'Content-Type': 'application/json' // specifico la uso
        },
        body: JSON.stringify(formData) // encode
    })
        .then(response => {
            console.log(response.statusText);
            return response.json();
        }) //prendo la risposta di registration backend(ha ottenuto i risultati delle query ) e li ha messi nella variabile
        .then(data => { //prendo i dati ottenuti e li processo
            if (data.success) {
                window.location.href = 'login.php'; // se chiamata è andata bene faccio display del main.php
            } else {
                window.alert('Registration failed'); //altimenti mando messaggio di errore
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

