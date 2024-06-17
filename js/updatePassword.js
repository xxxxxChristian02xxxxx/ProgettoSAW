function updatePassword() {

    document.getElementById('UserUpdate').addEventListener('submit', function (event) {
        event.preventDefault();

        const lastPassword = document.getElementById('lastpass').value;
        const newPassword = document.getElementById('pass').value;
        const confirm = document.getElementById('confirm').value;

        if(newPassword === confirm) {
            let data = {};

            data['lastPassword'] = lastPassword;

            data['newPassword'] = newPassword;

            data['confirm'] = confirm;

            fetch('../backend/be_changepassword.php', {
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
                .then(data => {
                    if(data['success'] == true) {
                        alert("Password changed successfully")
                    }else{
                        alert("Something went wrong")
                    }
                })
                .catch(error => {
                    console.error('Error: ', error);
                });
        }else{
            alert("Passwords are not the same")
        }
    })

}

document.addEventListener('DOMContentLoaded', function() {
    updatePassword()
})