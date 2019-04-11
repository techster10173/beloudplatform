<?php
session_start();

$server = "localhost";
$user = "root";
$pass = "usbw";
$db = "loginassignment";


$content = $_POST["tweetMaker"];
echo $_SESSION["myID"];
$tweetId = $_GET["id"];

$conn = new mysqli($server, $user, $pass, $db);

if($conn->connect_error)
{
    die("Connection Failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("INSERT INTO replies (content,userid,tweetid) VALUES (?,?,?)");
$stmt->bind_param("sii", $content, $_SESSION["myID"], $tweetId);
$stmt->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
