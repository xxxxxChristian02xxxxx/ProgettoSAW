document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('email').addEventListener('change', function (event) {
        const emailInput = document.getElementById('email').value;

        fetch('../backend/emailVerify.php', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
            },
            body: JSON.stringify({email: emailInput}),
        })
            .then(response => response.json())
            .then(data => {
                if(data['present']) {
                    document.getElementById('emailError').innerHTML = 'Email already used, try a different one';
                }else {
                    document.getElementById('emailError').innerHTML = ''
                }
            })
            .catch(error => {
                // Gestione degli errori durante la chiamata
                console.error('Si è verificato un errore durante la fetch:', error);
            })
    });
});