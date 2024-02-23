<?php

if(!function_exists('inputMailcheck')){
    function inputMailcheck($email){
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
if(!function_exists('inputSubject')){
    function inputSubject($name){
        $inputSubject = htmlspecialchars(trim($_POST['inputSubject']));

        if (preg_match("/^(?!\s*['']\s*$)[a-zA-Z0-9' ]{1,50}$/", $inputSubject)) {
            // Input is valid
            return true;
        } else {
            // Input is invalid
            return false;

        }
    }
}
if(!function_exists('inputMoney')) {
    function inputMoney($money)
    {
        $Money = filter_var(trim($money, FILTER_VALIDATE_INT));

        if ($Money !== false) {
            // Input is valid
            return true;

        } else {
            // Input is invalid
           return false;
        }
    }
}