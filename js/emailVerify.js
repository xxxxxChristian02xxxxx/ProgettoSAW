document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('email').addEventListener('change', function (event) {
        const emailInput = document.getElementById('email').value;

        fetch('../backend/emailVerify.php', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
            },
            body: JSON.stringify({email: emailInput, action:'checkPresenceEmail'}),
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
                if(data['present']) {
                    document.getElementById('emailError').innerHTML = 'Email already used, try a different one';
                    document.getElementById('email').classList.add('inputError');
                }else {
                    document.getElementById('emailError').innerHTML = ''
                    document.getElementById('email').classList.remove('inputError');
                }
            })
            .catch(error => {
                // Gestione degli errori durante la chiamata
                console.error('Si è verificato un errore durante la fetch:', error);
            })
    });
});