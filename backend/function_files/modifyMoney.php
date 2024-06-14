 <?php
session_start();
require('inputCheck.php');
function modifyMoney($email, $money){
    require('connection.php');
    $con = connect();

    $query = "UPDATE USERS SET MONEY = ?  WHERE EMAIL = ? AND ROLES != 1";
    $stmt = $con->prepare($query);
    $stmt->bind_param("is", $money,$email);
    $stmt->execute();

    if($stmt->affected_rows === 1) {
        $query = "SELECT MONEY FROM USERS WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc();
        $sanitized_data =htmlspecialchars($data['MONEY']);

        header('Content-Type: application/json');
        echo json_encode($sanitized_data);
    }else {
        echo('Something went wrong with the query result');
    }
}

function resetMoney($email){
    require('session.php');
    

    require('connection.php');
    $con = connect();

    $query = "UPDATE USERS SET MONEY = 0  WHERE EMAIL = ? AND ROLES != 1";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    if($stmt->affected_rows === 1){
        $query = "SELECT MONEY FROM USERS WHERE EMAIL = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc();
        $sanitized_data =htmlspecialchars($data['MONEY']);

        header('Content-Type: application/json');
        echo json_encode($sanitized_data);
    }
    else{
        echo('Something went wrong with the query result');
    }
}

$data = json_decode(file_get_contents('php://input'), true);
if($data && $_SERVER["REQUEST_METHOD"] === "POST") {
    require('session.php');
    
    if($_SESSION['loggedIn'] && $_SESSION['role']) {
        if (isset($data['action'])) {
            switch ($data['action']) {
                case 'modifyMoney':
                    if(!inputMoney( $data['money'])){
                        echo json_encode('no valid money');
                    }
                    modifyMoney($data['email'], $data['money']);
                    break;
                case 'resetMoney':
                    resetMoney($data['email']);
                    break;
            }
        } else {
            echo json_encode('Unsupported action');
        }
    }
    else{
        echo json_encode("You can't modify money, you're not an admin");
    }
}