<?php
include('backend/be_myprofile.php');
session_start();
include('backend/function_files/session.php');
$session = getSession(true);

$data = requestProfileData();

echo $data['FIRSTNAME'], $data['LASTNAME'], $data['EMAIL'];
?>