<?php
if(isset($_SESSION['loggedIn'])) {
    if($_SESSION['role']){
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