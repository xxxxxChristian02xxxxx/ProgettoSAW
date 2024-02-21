<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Garden</title>
    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <meta name ="viewport" content ="width=device-width,initial-scale=1.0">
    <link href="../dressing_garden.css" rel="stylesheet" type="text/css">
</head>
<body>
    <?php
    session_start();

    //Verifica se impostato un cookie
    include('../backend/function_files/verifyCookie.php');
    verifyCookie();
    //Aggiunta dell'header
    include('header.php');
    ?>
    <main class="wrapper">

    <div class="garden">
        <h1>My garden</h1>
        <div class="field" id="plants-container"></div>
        <script src ="../js/mygarden.js"></script>
    </div>
    </main>
    <footer id="footer">
        <?php
            include('footer.html');
        ?>
    </footer>
</body>
</html>