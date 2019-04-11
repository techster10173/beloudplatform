<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "usbw";
$db = "loginassignment";


$conn = new mysqli($server, $user, $pass, $db);

if($conn->connect_error)
{
    die("Connection Failed: " . $conn->connect_error);
}

$me = $_SESSION["myID"];
    $checkStmt = $conn->prepare("SELECT id FROM votes WHERE replyid = ? AND userid = ?");
    $checkStmt->bind_param("ii", $_GET["reply"], $me);
    $checkStmt->execute();
    $result = $checkStmt->get_result();
    if(mysqli_num_rows($result) == 0){
        $stmt = $conn->prepare("INSERT INTO votes (replyid,userid) VALUES (?,?)");
        $stmt->bind_param("ii", $_GET["reply"], $me);
        $stmt->execute();
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
 ?>
