<?php
session_start();

include 'credentials.php';

$me = $_SESSION["myID"];
$toFollow = $_GET["userid"];

if($row != $me){
    $stmt = $conn->prepare("INSERT INTO followers (follower,followee) VALUES (?,?)");
    $stmt->bind_param("ii", $me, $toFollow);
    $stmt->execute();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
 ?>
