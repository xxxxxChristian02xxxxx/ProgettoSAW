<?php
session_start();
include('backend/function_files/session.php');
$session = getSession();

if($_POST['submit']== 'submit'){
    include('backend/be_updateProfile.php');
    updateProfileData($_POST['email'],$_POST['firstname'], $_POST['lastname'],NULL);
}