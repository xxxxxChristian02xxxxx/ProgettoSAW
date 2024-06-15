 <?php
 require("function_files/test_session.php");
function logout()
{
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();

    session_destroy();

    $_SESSION["loggedIn"] = false;

    include('../backend/function_files/connection.php');
    $con = connect();

    if (isset($_COOKIE['ReMe'])) {
        $cookie_val = $_COOKIE['ReMe'];
        $decodedata = json_decode($cookie_val, true);

        $token_val = $decodedata['token_value'];
        $userId = $decodedata['id'];

        $query = "SELECT TOKEN FROM USERS WHERE ID=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        $stmt->bind_result($token_val);

        $stmt->fetch();

        $stmt->close();

        $query = "UPDATE USERS SET REMEMBER = 0, TOKEN = NULL, EXPIRE = NULL WHERE TOKEN=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('s', $token_val);

        $stmt->execute();

        $stmt->close();

        setcookie('ReMe', '', time() - 3600, "/");

        unset($_COOKIE);
        $con->close();
    }
    header("Location: ../frontend/index.html");
    exit();
}
logout();