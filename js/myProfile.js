function displayMyProfile(){
    fetch('../backend/be_myprofile.php', {
        method: 'POST',
        headers: {
            'Content-Type':'application/json'
        },
        body: JSON.stringify({action: 'requestProfileData'})
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
            document.getElementById('firstname').value = data['FIRSTNAME'];
            document.getElementById('lastname').value = data['LASTNAME'];
            document.getElementById('email').value = data['EMAIL'];
        })
        .catch(error => {
            console.error('Error: ', error);
        });
}

function updateDataProfile() {
    const storedFirstname = document.getElementById('firstname').value;
    const storedLastname = document.getElementById('lastname').value;
    const storedEmail = document.getElementById('email').value;

    document.getElementById('UserUpdate').addEventListener('submit', function (event) {
        event.preventDefault();

        const firstname = document.getElementById('firstname').value;
        const lastname = document.getElementById('lastname').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirm = document.getElementById('confirm').value;

        const data = [];

        if(firstname !== storedFirstname){
            data['firstname'] = firstname;
        }
        else{
            data['firstname'] = '';
        }

        if(lastname !== storedLastname){
            data['lastname'] = lastname;
        }
        else{
            data['lastname'] = '';
        }

        if(email !== storedEmail){
            data['email'] = email;
        }
        else{
            data['email'] = '';
        }

        if(password && confirm && password === confirm){
            data['password'] = password;
        }
        else{
            data['password'] = '';
        }

        fetch('../backend/be_myprofile.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({action: 'updateProfileData', data})
        })
            .catch(error => {
                console.error('Error: ', error);
            });
    })
}

displayMyProfile();
updateDataProfile();