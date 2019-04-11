<?php
session_start();
$_SESSION["kyahaiuser"] = "";
session_destroy();
header("Location:landing.html");
 ?>
