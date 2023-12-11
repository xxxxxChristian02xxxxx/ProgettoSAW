<?php
echo "<link href='../dressing.css' rel='stylesheet' type='text/css'>";
if(isset($_SESSION['loggedIn'])) {
    require('function_files\session.php');
    $session = getSession(true);


    echo "<a href=../main.php class='header_button'>Home</a>";
    echo "<a href='../myprofile.php' class='header_button'>Show profile</a>";
    if ($session['role'] == 1) {
        echo "<a href= ../editusers.php class='header_button'>Edit Users</a>";
    }
    echo "<a href=../logout.php class='header_button'>Logout</a>";

}
else{
    echo "<a href=index.php class='header_button'>Home</a>";
    echo "<a href=registration.php class='header_button'>Sign-up</a>";
    echo "<a href=login.php class='header_button'>Sign-in</a>";
}
?>

