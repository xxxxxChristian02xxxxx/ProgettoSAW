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
        //chiamata dal frontend login in backend login
        fetchRegistration(formData);
    }
});

function validateInput() {
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

function fetchRegistration(formData){
    fetch('../backend/be_registration.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
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
            if (data.success) {
                window.location.href = 'login.php';
            } else {
                window.alert('Registration failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}