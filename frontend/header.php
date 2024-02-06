<?php
echo "<link href='../dressing.css' rel='stylesheet' type='text/css'>";
if(isset($_SESSION['loggedIn'])) {
    include('../backend/function_files/session.php');
    $session = getSession(true);
    include('private_header.php');
}
else{
    include('public_header.html');
    header("Location: index.php");
}
?>

