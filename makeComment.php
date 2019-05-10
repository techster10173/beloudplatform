<?php
session_start();

include "credentials.php";

$content = $_POST["tweetMaker"];
echo $_SESSION["myID"];
$replyID = $_GET["id"];

$stmt = $conn->prepare("INSERT INTO comments (content,userid,replyid) VALUES (?,?,?)");
$stmt->bind_param("sii", $content, $_SESSION["myID"], $replyID);
$stmt->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
