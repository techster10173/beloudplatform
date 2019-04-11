<?php
include 'credentials.php';
session_start();

// $blah = $_GET["user"];

$sql = "DELETE FROM followers WHERE followers.follower=" . $_SESSION["myID"];
$result = $conn->query($sql);

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>
