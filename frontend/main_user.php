<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
</head>


<body>
<div id="header">
    <script>
        $(function () {
            $("#header").load("public_header.html");
        });
    </script>
</div>
<section id ="stopwatch">
   <button id = start> start</button>
    <button id =time>time</button>
</section>
<script>
    let intervalId;
    let time =0;
    const timeStart = document.getElementById("start");

    document.getElementById("start").addEventListener("click", ()=> {
       if (!intervalId) {
           intervalId = setInterval(() => {
               time++;
               document.getElementById("time").textContent = time;
           }, 1000);
       }
       document.getElementById("start").addEventListener("click", () => {
           clearInterval(intervalId);
           intervalId = null;

           document.getElementById("time").textContent = time;
       });
       document.getElementById("time").innerHTML = time;
   })
</script>

<footer>
    <p>Copyright © 2023. All rights reserved.</p>
</footer>
</body>
</html>