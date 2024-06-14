<?php
function connect()
{
    $con = new mysqli("localhost", "S5223956", "Dadedi1917", "S5223956");

    if ($con->connect_errno) {
        die("Failed to connect to server MySQL: " . $con->connect_error);
    }
    return $con;
}