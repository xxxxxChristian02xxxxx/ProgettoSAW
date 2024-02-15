document.getElementById('UserRegistration').addEventListener('submit', function (event) {

    event.preventDefault();

    const formData = {
        firstname: document.getElementById('firstname').value,
        lastname: document.getElementById('lastname').value,
        email: document.getElementById('email').value,
        pass: document.getElementById('pass').value,
        confirm: document.getElementById('confirm').value,
    };
    console.log(formData);
    //chimata dal frontend login in backend login
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
});