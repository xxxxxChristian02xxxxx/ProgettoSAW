<?php
$con = new mysqli("localhost", "root", "", "s5223956");

if ($con->connect_errno) {
    echo "Failed to connect to MySQL: " . $con -> connect_error;
    exit();
}
?>