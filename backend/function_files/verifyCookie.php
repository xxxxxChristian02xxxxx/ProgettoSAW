<?php
include('connection.php');
function verifyCookie()
{
    if (isset($_COOKIE['ReMe'])) {

        $con = connect();

        $cookie_val = $_COOKIE['ReMe'];
        $decodedata = json_decode($cookie_val, true);
        $token_val = $decodedata['token_value'];
        $id = $decodedata['id'];
        $query = "SELECT EXPIRE FROM USERS WHERE TOKEN = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $token_val);
        $stmt->execute();

        $res = $stmt->get_result();

        if ($res->num_rows === 1) {
            $expire = $res->fetch_assoc();
            if (date(time()) > $expire['EXPIRE']) {
                header("Location: frontend/login.php");
            } else {
                include('session.php');
                setSession($id);
            }
        } else {
            echo('Something went wrong with the query result');
        }
        $con->close();
    }
}
