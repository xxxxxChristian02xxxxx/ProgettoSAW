<?php
function setRememberMe($remember)
{
    if ($remember) {
        require('session.php');

        $expire = time() + ((60 * 60 * 24) * 7);
        $salt = "%salt&/";

        $token_value = hash('sha256', ("logged_in" . $salt));

        $sessiondata = json_encode(['token_value' => $token_value, 'id' => $_SESSION['id']]);

        setcookie('ReMe', $sessiondata, $expire, '/');
        $expire = date("Y-m-d", $expire);

        include("connection.php");
        $con = connect();

        $query = "UPDATE USERS SET REMEMBER = '1', TOKEN=?, EXPIRE=? WHERE ID=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ssi', $token_value, $expire, $_SESSION['id']);
        $stmt->execute();

        $stmt->close();
    }
}


