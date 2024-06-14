<?php
function getSession($wantData)
{
    if (isset($_SESSION['loggedIn'])) {
        if ($wantData) {
            $session = [];
            require('connection.php');
            $con = connect();
            $query = "SELECT * FROM USERS WHERE ID = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param('i', $_SESSION['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows === 1){
                $row=$result->fetch_assoc();

                $session['id'] = $row['ID'];
                $session['firstname'] = $row['FIRSTNAME'];
                $session['lastname'] = $row['LASTNAME'];
                $session['email'] = $row['EMAIL'];
                $session['role'] = $row['ROLES'];
            }
            else{
                echo('Something went wrong with the query result');
            }

            $con->close();

            return $session;
        }
        return true;
    } else {
        echo('User not logged in');
        header("Location: index.html");
        return false;
    }
}
function setSession($id)
{
    $_SESSION['loggedIn'] = true;
    $_SESSION['id'] = $id;
}






