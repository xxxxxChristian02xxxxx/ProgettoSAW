<?php
if(!function_exists('connect')) {
    function connect()
    {
        $con = new mysqli("localhost", "s5223956", "Dadedi1917", "s5223956");

        if ($con->connect_errno) {
            die("Failed to connecteddd to server MySQL: " . $con->connect_error);

        }
        return $con;
    }
}
?>