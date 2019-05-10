<?php
    include "credentials.php";

    $key=$_GET['query'];

    $query = "SELECT content FROM tweets WHERE content LIKE '%" . $key . "%'";

    $array = array();

    $result = $conn->query($query);
    while($row = $result->fetch_assoc())
    {
      $array[] = $row['content'];
    }

    $buery = "SELECT username FROM users WHERE username LIKE '%" . $key . "%'";
    $kesult = $conn->query($buery);
    while($row = $kesult->fetch_assoc())
    {
      $array[] = "@" . $row['username'];
    }

    echo json_encode($array);
?>
