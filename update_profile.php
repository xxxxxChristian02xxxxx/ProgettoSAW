<?php
session_start();

if($_POST['submit']== 'submit'){
    include('backend/be_updateprofile.php');
    updateProfileData($_POST['firstname'], $_POST['lastname'],$_POST['email']);
}