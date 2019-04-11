<?php
include 'credentials.php';

$username = $_POST["usern"];
$password = $_POST["passw"];

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

 ?>
