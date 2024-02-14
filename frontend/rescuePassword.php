
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Rescue Password</title>
</head>

<body>

<div class="rescuePassword">
    <h1>Rescue password</h1>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email"><br>
        <span id="emailError" class="error"></span>

        <label for="pass">New password:</label>
        <input type="password" id="pass" name="pass"><br>

        <label for="confirm">Confirm new password:</label>
        <input type="password" id="confirm" name="confirm"><br>

        <button id="update">Update</button>
    </div>

</div>
</body>
</html>
<script>

    window.addEventListener("DOMContentLoaded", () => {

        let update = document.getElementById("update");
        update.addEventListener("click", ()=>{
            let email = document.getElementById("email").value;
            let password= document.getElementById("pass").value;
            let confiermPass= document.getElementById("confirm").value;
            console.log("fatto ",);
            if(password === confiermPass){
                console.log("o")
                mailFetch(confiermPass,email);
            }

        })

    })

    function mailFetch(confiermPass,email){
        fetch('../backend/function_files/forgottenPasswordLogin.php', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
            },
            body: JSON.stringify({email: email,action:'checkPresenceEmail' }),
        })
            .then(response => response.json())
            .then(data => {
                console.log("fatto mail");
                if(data['present']) {
                    console.log("password found");
                    passwordFetch(email,confiermPass);
                }
            })
            .catch(error => {
                // Gestione degli errori durante la chiamata
                console.error('Si è verificato un errore durante la fetch:', error);
            })
    }
    function passwordFetch(email,confiermPass){
        fetch('../backend/function_files/forgottenPasswordLogin.php', {
            method: 'POST',
            headers: {
                'Content-type': 'application/json',
            },
            body: JSON.stringify({email:email, password:confiermPass, action: 'updatePasswordLogin' }),
        })
            .then(response => response.json())
            .then(data => {
             console.log("modificata");
            })
            .catch(error => {
                // Gestione degli errori durante la chiamata
                console.error('Si è verificato un errore durante la fetch:', error);
            })
    }

</script>

