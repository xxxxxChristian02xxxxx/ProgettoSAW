<?php
include('backend/be_show_profile.php');
session_start();

echo $_SESSION['firstname'], $_SESSION['lastname'], $_SESSION['email'];
