<?php
$con = new mysqli("localhost", "s5223956", "Dadedi1917", "s5223956");

if ($con->connect_errno) {
    die("Failed to connect to MySQL: " . $con -> connect_error);

}
?>