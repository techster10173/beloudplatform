<?php
session_start();

include 'credentials.php';

$me = $_SESSION["myID"];
$toFollow = $_SESSION["dude"];

$getuser = $conn->prepare("SELECT id FROM users WHERE username=?");
$getuser->bind_param("s",$toFollow);
$getuser->execute();
$getuser->bind_result($row);
$getuser->fetch();
$bow = $row;
$getuser->close();

if($row != $me){
    $stmt = $conn->prepare("INSERT INTO followers (follower,followee) VALUES (?,?)");
    $stmt->bind_param("ii", $me, $bow);
    $stmt->execute();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
 ?>
