
<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <title>Rescue Password</title>
    <link href="rescuePassword.css" rel="stylesheet" type="text/css">

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
            body: JSON.stringify({email: email, action:'checkPresenceEmail' }),
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if(data['present']) {
                    popup(email,confiermPass);

                }else{
                    let emailError = document.getElementById("emailErro");
                    emailError.classList.remove("errore")

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


            .catch(error => {
                // Gestione degli errori durante la chiamata
                console.error('Si è verificato un errore durante la fetch:', error);
            })
    }
    function popup(email,confiermPass) {
        const popUp = document.getElementById('popUp');
        const popUpContent = document.getElementById('popUpContent');
        if (popUp && popUpContent) {
            popUp.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            appendPasswordModify(popUpContent,email);
            const option1 =document.getElementById("option1")
            const option2 =document.getElementById("option2")
            const option3 =document.getElementById("option3")
            const closePopUpButton = document.getElementById('closePopUpButton');
            let num1= Math.floor(Math.random() * 100).toString();
            let num2= Math.floor(Math.random() * 100).toString();
            let num3= Math.floor(Math.random() * 100).toString();
            while (num1 === num2 || num1 === num3) {
                num1 = Math.floor(Math.random() * 4);
            }
            while (num2 === num3) {
                num2 = Math.floor(Math.random() * 4);
            }
            var options=[num1,num2,num3] ;
            var randomNumber = Math.floor(Math.random() * 3);
            var numTarget  =options[randomNumber];
            option1.innerText=num1.toString();
            option2.innerText=num2.toString();
            option3.innerText=num3.toString();
            console.log(numTarget);
            option1.addEventListener('click', () => {
                if(num1 ===numTarget) {
                    console.log("premuto")
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    passwordFetch(email,confiermPass);
                }
            });
            option2.addEventListener('click', () => {

                if(num2 ===numTarget) {
                    console.log("premuto")
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    passwordFetch(email,confiermPass);
                }
            });
            option3.addEventListener('click', () => {

                if(num3 ===numTarget) {
                    console.log("premuto")
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                    passwordFetch(email,confiermPass);
                }
            });

            closePopUpButton.addEventListener('click', () => {
                console.log("premuto")
                popUp.classList.add('hidden');
                document.body.style.overflow = 'auto';
            });

            popUp.addEventListener('click', (event) => {
                if (event.target === popUp) {
                } else if (event.target.closest('#modalContent') === null) {
                    popUp.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            });

            popUpContent.addEventListener('click', (event) => {
                event.stopPropagation();
            });


        }
    }
    function appendPasswordModify(popUpContent,email) {
        let gridHtml = '';
        gridHtml += generatePasswordModify(email);
        popUpContent.innerHTML = gridHtml;
    }

    function generatePasswordModify(email) {
        console.log("p");
        return `
        <h2>Check your email to proceed</h2>
                <span id="closePopUpButton" class="close">&times;</span>
                <div>
                    <p >Your email : ${email.value} <p>
                </div>
                <div>
                    <p >An e-mail has been sent to you, just click the number you see on your mail to proceed <p>
                </div>
                <div>
                    <button class="circle-button" id ="option1"></button>
                    <button class="circle-button" id ="option2"></button>
                    <button class="circle-button" id ="option3"></button>
                </div>
  `
    }

</script>

