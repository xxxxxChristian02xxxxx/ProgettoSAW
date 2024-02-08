<?php

//funzione per prelevare tutti i record di una tabella
if (!function_exists('selectallll')) {
    function selectall()
    {
        require('connection.php');
        $con = connect();

        $sql = "SELECT * FROM USERS ";
        $stm = $con->prepare($sql);

        //Esecuzione della query
        $stm->execute();
        $res =$stm->get_result();
        //creo il vettore in cui immagazzino le informazioni del db
        $row = $res->fetch_assoc();

        return $row;
    }
}

//funzione per ritornare il ruolo di un utente
if (!function_exists('getrole')) {
    function getrole($id)
    {
        require('connection.php');
        $con = connect();
        $sql = "SELECT ROLES FROM USERS WHERE ID = ? ";
        $role_stmt = $con->prepare($sql);
        $role_stmt->bind_param('i',$id);
        if ($id == 'self') {
            $role_stmt->bind_param('i', $_SESSION['id']);
        }else{
            $role_stmt->bind_param('i', $id);
        }

        //Esecuzione della query
        $role_stmt->execute();
        $role_stmt->bind_result($role);
        $role_stmt->fetch();

        return $role;
    }
}

//funzione per  controlli degli errori
if (!function_exists('Check_Sql')) {
    function Check_Sql($statement) {
        if (!$statement) {
            echo "Errore nella preparazione della query.";
            return false;
        }

        if (!$statement->execute()) {
            echo "Errore durante l'esecuzione della query: " . $statement->error;
            return false;
        }

        $result = $statement->get_result();

        if (!$result) {
            echo "Errore nell'ottenere il risultato della query.";
            return false;
        }

        return true;
    }
}

if (!function_exists('DisplayTend_Sql')) {
    function DisplayTend_Sql($statement) {
        require('connection.php');
        $con = connect();

    }
}

?>