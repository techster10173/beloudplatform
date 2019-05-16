<?php
include 'credentials.php';
session_start();

$sql = "DELETE FROM block WHERE block.blocker=" . $_SESSION["myID"] . " AND block.blockee = " . $_GET["userid"];
$result = $conn->query($sql);
// header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
