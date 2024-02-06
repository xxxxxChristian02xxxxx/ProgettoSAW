<?php
if (!function_exists('getSession')) {
    function getSession($wantData)
    {
        if (isset($_SESSION['loggedIn'])) {
            if ($wantData) {
                $session = [];
                require('connection.php');
                $con = connect();
                $query = "SELECT * FROM USERS WHERE ID =" . $_SESSION['id'];
                $row = $con->query($query)->fetch_assoc();
                $con->close();
                $session['id'] = $row['ID'];
                $session['firstname'] = $row['FIRSTNAME'];
                $session['lastname'] = $row['LASTNAME'];
                $session['email'] = $row['EMAIL'];
                $session['role'] = $row['ROLES'];
                return $session;
            }
            return true;
        } else {
            echo('user not logged in');
            header("Location: index.php");
        }
    }
}
if(!function_exists('setSession')) {
    // TODO: change the parameters to id (have to do a query to get the other data)
    function setSession($id)
    {
        $_SESSION['loggedIn'] = true;
        $_SESSION['id'] = $id;
    }
}





