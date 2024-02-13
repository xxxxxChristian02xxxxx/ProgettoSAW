function displayMyProfile(){
    fetch('../backend/be_myprofile.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.getElementById('firstname').value = data['FIRSTNAME'];
            document.getElementById('lastname').value = data['LASTNAME'];
            document.getElementById('email').value = data['EMAIL'];
        })
}

displayMyProfile();