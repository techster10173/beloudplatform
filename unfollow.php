<?php
include 'credentials.php';
session_start();

/*Prepared Statement*/
$sql = "DELETE FROM followers WHERE followers.follower=" . $_SESSION["myID"] . " AND followers.followee = " . $_GET["userid"];
$result = $conn->query($sql);

// header('Location: ' . $_SERVER['HTTP_REFERER']);

?>
