<?php
session_start();

include 'credentials.php';

$username = $_POST["userna"];
$password = $_POST["passwo"];

        $stmt = $conn->prepare("SELECT username FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();

        $getuser = $conn->prepare("SELECT id FROM users WHERE username=?");
        $getuser->bind_param("s",$username);
        $getuser->execute();
        $getuser->bind_result($row);
        $getuser->fetch();

        if(($stmt->num_rows) > 0) {
            header("Location:home.php");
            $_SESSION["kyahaiuser"] = $username;
            $_SESSION["myID"] = $row;
        }else{
            echo "<script type='text/javascript'>alert('Oops your username or password might be wrong...Try Again?');window.location='index.html';</script>";
        }

 ?>
