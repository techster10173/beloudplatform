<?php
session_start();

include 'credentials.php';


$content = $_POST["tweetMaker"];
// echo $_SESSION["myID"];

$stmt = $conn->prepare("INSERT INTO tweets (content,userid) VALUES (?,?)");
$stmt->bind_param("si", $content, $_SESSION["myID"]);
$stmt->execute();
$bello = $conn->insert_id;

header("Location:home.php");

?>
