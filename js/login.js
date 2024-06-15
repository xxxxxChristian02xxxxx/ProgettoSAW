document.getElementById('UserLogin').addEventListener('submit', function (event) {

    event.preventDefault();

    const formData = {
        email: document.getElementById('email').value,
        pass: document.getElementById('pass').value,
        ReMe: document.getElementById('ReMe').checked
    };

    if(formData['email'] && formData['pass']){
        fetch('../backend/be_login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(formData)
        })
            .then(response => {
                console.log(response);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                if (response.status === 204) {
                    return null;
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                if (data.success && !data.banned) {
                    window.location.href = 'main.php';
                }
                else if(!data.success && data.banned) {
                    window.alert("You can't login, you're banned!");
                }
                else {
                    window.alert("Login failed");
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    else{
        if(!formData['email']){
            alert("Insert an email to login");
        }
        else{
            alert("Insert password to login");
        }
    }
});