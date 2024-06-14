<?php
if(isset($_SESSION['loggedIn'])) {
    include('../backend/function_files/session.php');
    $session = getSession();
    if($session['role']){
        include('privateHeaderAdmin.html');

    }
    else{
        include('privateHeader.html');

    }
}
else{
    include('public_header.html');

    header("Location: index.html");
}