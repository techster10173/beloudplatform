<?php
session_start();

include "credentials.php";

$content = $_POST["tweetMaker"];
$tweetId = $_GET["id"];

$stmt = $conn->prepare("INSERT INTO replies (content,userid,tweetid) VALUES (?,?,?)");
$stmt->bind_param("sii", $content, $_SESSION["myID"], $tweetId);
$stmt->execute();
$bello = $conn->insert_id;

ini_set("error_reporting", 1);
if(isset($_POST['btnSubmit']))
{
    for ($i = 0; $i < count($_FILES['files']['name']); $i++)
    {
        if ($_FILES["files"]["size"][$i] < 1000000) // Check File size (Allow 1MB)
        {
            $temp = $_FILES["files"]["tmp_name"][$i];
            $name = $_FILES["files"]["name"][$i];
            $type = $_FILES['files']['type'][$i];
            echo $type;

            if(empty($temp))
            {
                break;
            }
            if($i == 0){ $err = "File uploaded successfully"; $cls = "success"; }
            move_uploaded_file($temp,"userfiles/".$name);
            $hello = "userfiles/" . $name;
            $query = $conn->prepare("INSERT INTO fileuploads (name, solutionid) VALUES (?,?)");
            $query->bind_param("si", $hello, $bello);
            $query->execute();
        }
        else
        {
            $err = "File size is more than 1MB";
            $cls = "danger";
        }
    }
}
// header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
