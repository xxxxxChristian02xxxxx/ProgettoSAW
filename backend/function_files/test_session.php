<?php
if(!isset($_SESSION['loggedIn'])) {
    header("Location: ../frontend/index.html");
}