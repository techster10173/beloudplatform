<?php 
$server = "localhost";

$user = "root";

$pass = "usbw";

$db = "loginassignment";

$conn = new mysqli($server, $user, $pass, $db);
// connect to MySQL server

if($conn->connect_error) // check if connection failed
{
    die("Connection Failed: " . $conn->connect_error);
} ?>
