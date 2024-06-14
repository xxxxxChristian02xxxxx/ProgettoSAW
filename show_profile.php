<?php
include('backend/be_show_profile.php');
session_start();
include('backend/function_files/session.php');
$session = getSession(true);

$data = rethriveData();

echo $data['FIRSTNAME'], $data['LASTNAME'], $data['EMAIL'];
