
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Users</title>
</head>


<body>
<?php

//Verifica che la sessione sia attiva
require("function_files/session.php");
getSession(false);

//Aggiunta dell'header
require("header.php");

include("function_files/connection.php");
$con = connect();

$sql = "SELECT * FROM USERS"; // query
$res = $con->prepare($sql); // execute query
$res->execute();
$result = $res->get_result();
$i = 0;
echo "<br>";
?>
    <section id="modify_users_section">
    <table id ="modify_users_table" >
            <tr style="border:1px solid black;">
            <th style="border:1px solid black;"><?php echo "ID" ?></th>
            <th style="border:1px solid black;"><?php echo "NAME" ?></th>
            <th style="border:1px solid black;"><?php echo "LASTNAME" ?></th>
            <th style="border:1px solid black;"><?php echo "EMAIL" ?></th>
            <th style="border:1px solid black;"><?php echo "PASSWORD" ?></th>
            <th style="border:1px solid black;"><?php echo "ROLES" ?></th>
            <th style="border:1px solid black;"><?php echo "BANNED" ?></th>
            <th style="border:1px solid black;"><?php echo "REMEMBER" ?></th>
        </tr>
<?php

while ($page = $result->fetch_assoc()) { // loop
    ?>

            <tr>
                <td style="border:1px solid black;"><?php echo $page["ID"] ?></td>
                <td style="border:1px solid black;"><?php echo $page["FIRSTNAME"] ?></td>
                <td style="border:1px solid black;"><?php echo $page["LASTNAME"] ?></td>
                <td style="border:1px solid black;"><?php echo $page["EMAIL"] ?></td>
                <td style="border:1px solid black;"><?php echo $page["PASSWORD"] ?></td>
                <td style="border:1px solid black;"><?php echo $page["ROLES"] ?></td>
                <td style="border:1px solid black;"><?php echo $page["BANNED"] ?><br>
                    <form method="post">
                        <input type="hidden" name="id" value=<?php echo $page["ID"];?> >
                        <input type="hidden" name="ban" value=<?php echo $page["BANNED"];?>>
                        <?php
                        if($page["BANNED"]){
                            echo '<input type="submit" value="Unban">';
                        }
                        else{
                            echo '<input type="submit" value="Ban">';
                        }
                        ?>

                    </form>
                </td>
                <td style="border:1px solid black;"><?php echo $page["REMEMBER"] ?></td>
            </tr>

    <?php

}
// Chiusura della connessione
$res->close();
$con->close();
?>
    </table>
    </section>
<section>
    <p>
        molto brutto, lo so, ma era per il debug
    </p>
</section>

<?php
$con = connect();
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $ban = $_POST['ban'];
    $id = $_POST['id'];

    $sql ="SELECT ROLES FROM USERS WHERE ID = ? ";
    $role_stmt = $con->prepare($sql);
    $role_stmt->bind_param('i', $id);

//Esecuzione della query
    $role_stmt->execute();
    $role_stmt->bind_result($role);
    $role_stmt->fetch();

    if ($role_stmt->affected_rows == 0) {
        echo "no rows inserted / updated / canceled";
    }
    $role_stmt->close();

    if ($role != 1) {

        $ban = !$ban;
        $sql = "UPDATE USERS SET BANNED = ? WHERE ID =? ";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ii', $ban, $id);

        $stmt->execute();

        if ($stmt->affected_rows != 1) {
            echo "errore nell'update ";
        }
        $stmt->close();
        header("Location: editusers.php");
    }else{
        echo "nada";
    }
}
?>












<script>
    function ban_unban($ban, $id){
        <?php
        $con = connect();

        $ban = !ban;

        $sql= "UPDATE USERS SET BANNED = ? WHERE ID =? ";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ii',$ban, $id);

        $stmt->execute();
        if($stmt->affected_rows != 1){
            echo "errore nell'update ";
        }

        $stmt-> close();


        ?>
    }
    </script>
