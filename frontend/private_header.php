<link href='../header.css' rel='stylesheet' type='text/css'>
<header>
    <div id="privateheaderButton">
        <div class="left_button">
            <div id="homeButton">
                <a href='main.php' class='header_button'>Home</a>
            </div>
            <div id="myGardenButton">
                <a href='mygarden.php' class='header_button'>My Garden</a>
            </div>
            <div id="studySessionButton">
                <a href='studysessions.php' class='header_button'>Study Sessions</a>
            </div>
            <div id="globalRankButton">
                <a href='globalRanking.php' class='header_button'>Global Ranking</a>
            </div>
        </div>

        <div class="right_button">
            <div id="showProfileButton">
                <a href='myprofile.php' class='header_button'>Show profile</a>
            </div>
            <?php
            if ($session['role'] == 1) {
                echo "<div id='editUserButton'>
                       <a href='editusers.php' class='header_button admin_only'>Edit Users</a>
                  </div>";
            }
            ?>
            <div id="logoutButton">
                <a href='logout.php' class='header_button'>Logout</a>
            </div>
        </div>
    </div>
</header>
