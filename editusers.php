
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

include("function_files/connection.php");
$con = connect();


if (!getrole('self')){
    header('Location: main.php');
}



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


    include("function_files/connection.php");
    $con = connect();

    $role = getrole($id);
    echo $role;
    if ($role != 1) {

        $ban = !$ban;
        $sql = "UPDATE `users` SET `BANNED` = ? WHERE `users`.`ID` = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ii', $ban, $id);

        $stmt->execute();

        if ($stmt->affected_rows != 1) {
            echo $stmt->affected_rows;
        }
        $stmt->close();
        echo '<script>window.location.href = "editusers.php";</script>';
    }else{
        echo "nada";
    }

}
?>












