<?php
if(isset($_SESSION['loggedIn'])){
    echo "<a href=main.php>| Home </a>";
    echo "<a href=''>| Show profile </a>";
    echo "<a href=logout.php>| Logout | </a>";
}
else{
    echo "<a href=index.php>| Home </a>";
    echo "<a href=registration.php>| Sign-Up </a>";
    echo "<a href=login.php>| Sign-In | </a>";
}
?>