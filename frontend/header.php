<?php
echo "<link href='dressing.css' rel='stylesheet' type='text/css'>";
if(isset($_SESSION['loggedIn'])) {
    include('backend/function_files/session.php');
    $session = getSession(true);
    include('frontend/private_header.html');
}
else{
    include('frontend/public_header.html');
}
?>

