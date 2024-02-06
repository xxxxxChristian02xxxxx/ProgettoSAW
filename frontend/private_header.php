<link href='../dressing.css' rel='stylesheet' type='text/css'>
<header>
  <a href='main.php' class='header_button'>Home</a>
  <a href='myprofile.php' class='header_button'>Show profile</a>
  <?php
    if ($session['role'] == 1) {
      echo "<a href='editusers.php' class='header_button admin_only'>Edit Users</a>";
    }
  ?>
  <a href='studysessions.php' class='header_button'>Study Sessions</a>
  <a href='logout.php' class='header_button'>Logout</a>
</header>
