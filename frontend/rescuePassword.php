
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Rescue Password</title>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link href="../form.css" rel="stylesheet" type="text/css">
    <link href="../rescuePassword.css" rel="stylesheet" type="text/css">
</head>

<body>

<div class="rescuePassword">
    <div class="headerRescuePassword">
        <h1>Rescue password</h1>
    </div>
    <div class="rescuePasswordForm">
        <form id="UserRescuePassword" action="rescuePassword.php" method="POST">
            <div class="Email">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <span id="emailErro" class="errore">error</span><br>
            </div>

            <div class="Password">
                <label for="pass">New password:</label>
                <input type="password" id="pass" name="pass"><br>
            </div>

            <div class="ConfirmPassword">
                <label for="confirm">Confirm new password:</label>
                <input type="password" id="confirm" name="confirm"><br>
            </div>

            <div id="Submit">
                <input id="update" type="submit" value="Update">
            </div>
        </form>
    </div>
    <div id="popUp" class="hidden">
        <div id="popUpContent">
        </div>
    </div>
</div>
</body>
</html>
<script src="../js/rescuePassword.js"></script>
<script>

    window.addEventListener("DOMContentLoaded", () => {
        document.getElementById('UserRescuePassword').addEventListener('submit', function(event) {
            event.preventDefault();
            let update = document.getElementById("update");
            update.addEventListener("click", ()=>{
                let email = document.getElementById("email").value;
                let password= document.getElementById("pass").value;
                let confiermPass= document.getElementById("confirm").value;
                if(password === confiermPass){
                    mailFetch(confiermPass,email);
                }
            })
        })

    })

</script>

