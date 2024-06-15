<?php
function setSession($id, $firstname, $lastname, $email, $roles)
{
    $_SESSION['loggedIn'] = true;
    $_SESSION['id'] = $id;
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $lastname;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $roles;
}






