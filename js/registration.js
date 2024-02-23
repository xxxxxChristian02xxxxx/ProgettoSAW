document.getElementById('UserRegistration').addEventListener('submit', function (event) {
    event.preventDefault();
    if(validateInput()) {
        const formData = {
            firstname: document.getElementById('firstname').value,
            lastname: document.getElementById('lastname').value,
            email: document.getElementById('email').value,
            pass: document.getElementById('pass').value,
            confirm: document.getElementById('confirm').value,
        };
        console.log(formData);
        //chiamata dal frontend login in backend login
        fetchRegistration(formData);
    }
});


function validateInput() {

    // Recupero dei valori inseriti in input
    const firstname = document.getElementById('firstname').value;
    const lastname = document.getElementById('lastname').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('pass').value;
    const confirm = document.getElementById('confirm').value;


    if (firstname === '') {
        document.getElementById('firstnameError').innerHTML = 'Firstname is required!';
        document.getElementById('firstname').classList.add('inputError');
        return false;
    }
    else{
        document.getElementById('firstnameError').innerHTML = '';
        document.getElementById('firstname').classList.remove('inputError');
    }

    if (lastname === '') {
        document.getElementById('lastnameError').innerHTML = 'Lastname is required!';
        document.getElementById('lastname').classList.add('inputError');
        return false;
    }
    else{
        document.getElementById('lastnameError').innerHTML = '';
        document.getElementById('lastname').classList.remove('inputError');
    }

    if (email === '') {
        document.getElementById('emailError').innerHTML = 'Email is required!';
        document.getElementById('email').classList.add('inputError');
        return false;
    }
    else{
        document.getElementById('emailError').innerHTML = '';
        document.getElementById('email').classList.remove('inputError');
    }

    if (password !== '' && confirm !== '') {
        document.getElementById('confirmError').innerHTML = '';
        document.getElementById('pass').classList.remove('inputError');
        document.getElementById('confirm').classList.remove('inputError');
        if (password !== confirm) {
            alert('Passwords do not match');
            return false;
        }
    } else {
        document.getElementById('confirmError').innerHTML = 'Password and confirm are required!';
        document.getElementById('pass').classList.add('inputError');
        document.getElementById('confirm').classList.add('inputError');
        return false;
    }

    return true;
}

document.querySelectorAll('')
function fetchRegistration(formData){
    fetch('../backend/be_registration.php', { // dico il percorso del file di back end
        method: 'POST', //metodo get o post
        headers: {
            'Content-Type': 'application/json' // specifico la uso
        },
        body: JSON.stringify(formData) // encode
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            if (response.status === 204) { // No content
                return null;
            }
            console.log(response)
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