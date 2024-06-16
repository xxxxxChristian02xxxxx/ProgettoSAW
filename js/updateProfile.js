function displayMyProfile(){
    fetch('../backend/be_updateprofile.php', {
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
            if (response.status === 204) {
                return null;
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('firstname').value = data['FIRSTNAME'];
            document.getElementById('lastname').value = data['LASTNAME'];
            document.getElementById('email').value = data['EMAIL'];
            updateDataProfile();
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

        let data = {};

        data['firstname'] = firstname;

        data['lastname'] = lastname;

        data['email'] = email;


        console.log(data)
        fetch('../backend/be_updateprofile.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({data: data, action: 'updateProfileData'})
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                if (response.status === 204) { // No content
                    return null;
                }
                return response.json()
            })
            .then(data=>{
                console.log(data);
                window.location.reload();
            })
            .catch(error => {
                console.error('Error: ', error);
            });
    })
}

document.addEventListener('DOMContentLoaded', function() {
    displayMyProfile();
    document.getElementById("changePassword").addEventListener('click', function(event) {
        event.preventDefault();
        window.location.href = "../frontend/change_password.php";
    });
})
