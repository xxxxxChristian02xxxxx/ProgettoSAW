
<?php
session_start();

/*
verifica sessione
includere header.php
mosrtare form del db che mostra la tabella USERS (estraggo dati dal db)
su ogni riga implementazione bottoni delete e ban
*/
//Verifica che la sessione sia attiva
require("function_files/session.php");
getSession(false);

//Aggiunta dell'header
require("header.php");

include("function_files/connection.php");
$con = connect();

//creazione prepared statemet per prelevare tutta la tabella
//$query = "SELECT * FROM USERS";
//$stmt = $con->prepare($query);
//$stmt->execute();

//$stmt->bind_result($id,$name,$lastname,$mail,$password,$roles,$banned,$remember);
//$stmt->fetch();
//echo $id.$name.$lastname.$mail.$password.$roles.$banned.$remember;
$sql = "SELECT * FROM USERS"; // query
$res = $con->prepare($sql); // execute query
$res->execute();
$result = $res->get_result();
$i = 0;
echo "<br>";
?>
    <section>
    <table style="border:1px solid black;width:100%;">
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
    $id =  $_POST['id'];
    $ban =  !$ban;
    echo $ban . " ". $id;
    $sql= "UPDATE USERS SET BANNED = ? WHERE ID =? ";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('ii',$ban, $id);

    $stmt->execute();
    if($stmt->affected_rows != 1){
        echo "errore nell'update ";
    }
    $stmt->close();
    header("Location: editusers.php");
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
