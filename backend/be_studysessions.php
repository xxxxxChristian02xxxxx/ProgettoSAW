<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('function_files/session.php');
$session = getSession(true);

require("function_files/connection.php");
$con = connect();

if(isset($_GET['column'])) {
    $selectedColumn = $_GET['column'];

    $query = "SELECT DISTINCT $selectedColumn FROM STUDY_SESSIONS WHERE USERS.EMAIL=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('s', $session['email']);
    $stmt->execute();

    $result = $stmt->get_result();

    $values = array();

    header('Content-Type: application/json');
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $values[] = $row[$selectedColumn];
        }
    }

    echo json_encode($values);
}
else{
    json_encode(['error' => 'missing column parameter']);
}

$query = "SELECT SUBJECTS.NAME AS SUBJECT, STUDY_SESSIONS.TYPE, STUDY_SESSIONS.DATE, STUDY_SESSIONS.TOTAL_TIME, STUDY_SESSIONS.TOTAL_REWARD, STUDY_SESSIONS.DESCRIPTION 
          FROM STUDY_SESSIONS 
          INNER JOIN USERS ON STUDY_SESSIONS.USER = USERS.ID 
          INNER JOIN SUBJECT_SESSIONS ON STUDY_SESSIONS.SESSION_ID = SUBJECT_SESSIONS.SESSION_ID
          INNER JOIN SUBJECTS ON SUBJECT_SESSIONS.SUBJECT_ID = SUBJECTS.ID
          WHERE USERS.EMAIL =?";
$stmt = $con->prepare($query);
$stmt->bind_param('s', $session['email']);
$stmt->execute();

$data = array();

$result = $stmt->get_result();

header('Content-Type: application/json');
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
}

$con->close();

echo json_encode($data);
?>