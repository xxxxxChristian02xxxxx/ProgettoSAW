<?php
require('connection.php');
function setSession($id)
{
    $_SESSION['loggedIn'] = true;
    $_SESSION['id'] = $id;

    $con = connect();
    $query = "SELECT * FROM USERS WHERE ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $row=$result->fetch_assoc();

        $_SESSION['id'] = $row['ID'];
        $_SESSION['firstname'] = $row['FIRSTNAME'];
        $_SESSION['lastname'] = $row['LASTNAME'];
        $_SESSION['email'] = $row['EMAIL'];
        $_SESSION['role'] = $row['ROLES'];
    }
    else{
        echo('Something went wrong with the query result');
    }

    $con->close();

}






