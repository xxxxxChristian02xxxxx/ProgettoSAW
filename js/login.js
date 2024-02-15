document.getElementById('UserLogin').addEventListener('submit', function (event) {

    event.preventDefault();

    const formData = {
        email: document.getElementById('email').value,
        pass: document.getElementById('pass').value,
        ReMe: document.getElementById('ReMe').checked
    };

    //chimata dal frontend login in backend login
    fetch('../backend/be_login.php', { // dico il percorso del file di back end
        method: 'POST', //metodo get o post
        headers: {
            'Content-Type': 'application/json' // specifico la uso
        },
        body: JSON.stringify(formData) // encode
    })
        .then(response => response.json()) //prendo la risposta di login backend(ha ottenuto i risultati delle query ) e li ha messi nella variabile
        .then(data => { //prendo i dati ottenuti e li processo

            if (data.success) {
                window.location.href = 'main.php'; // se chiamata è andata bene faccio display del main.php
            } else {
                window.alert('login failed'); //altimenti mando messaggio di errore
            }
        })
        .catch(error => {

            console.error('Error:', error);
        });
});