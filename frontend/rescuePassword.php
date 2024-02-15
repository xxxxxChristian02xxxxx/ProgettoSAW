
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Rescue Password</title>
    <link href="../rescuePassword.css" rel="stylesheet" type="text/css">

</head>

<body>

<div class="rescuePassword">
    <h1>Rescue password</h1>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
        <span id="emailErro" class="errore">error</span><br>

        <label for="pass">New password:</label>
        <input type="password" id="pass" name="pass"><br>

        <label for="confirm">Confirm new password:</label>
        <input type="password" id="confirm" name="confirm"><br>

        <button id="update">Update</button>
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






</script>

