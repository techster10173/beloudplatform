<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<nav class="navbar navbar-light bg-light justify-content-between">
    <a class="navbar-brand">
        <?php
        include 'credentials.php';

        session_start();
        if($_SESSION["kyahaiuser"] == ""){
            header("Location:landing.html");
        }
        echo "@" . $_GET["name"];
        ?>
    </a>
  <form class="form-inline">
      <div class="btn-group">
          <?php
          $otherUser = $_GET["name"];

          $pql = "SELECT id FROM users WHERE username='" . $_GET["name"]."'";
          $besult=$conn->query($pql);
          $otherid;

          while($row = $besult->fetch_assoc()){
              $otherid = $row["id"];
          }

          $id = $otherid;
          include "getFollowDetails.php";

          ?>
        </div>
  </form>
  <div class="row">
        <div class="span6">
  <form action="follow.php?userid=<?php echo $otherid ?>" method="post">
      <?php
      /*Prepared Statement*/
            $sql = "SELECT followers.id FROM followers WHERE followers.followee=" . $otherid . " AND followers.follower =" . $_SESSION["myID"];
            $result = $conn->query($sql);
            if($_SESSION["kyahaiuser"] != $_GET["name"]){
            if(mysqli_num_rows($result) == 0){
                echo "<button type='submit' class='btn btn-primary'><i class='fas fa-user-plus'></i></button>";
            }else{
                echo "<button type='submit' formaction='unfollow.php?userid=" . $otherid . "' class='btn btn-primary'><i class='fas fa-user-minus'></i></button>";
            }
        }
      ?>
  </form>
</div>
  <div class="span6">
  <form action="block.php?userid=<?php echo $otherid ?>" method="post">
      <?php
      /*Prepared Statement*/
            $sql = "SELECT block.id FROM block WHERE block.blockee=" . $otherid . " AND block.blocker =" . $_SESSION["myID"];
            $result = $conn->query($sql);
            if($_SESSION["kyahaiuser"] != $_GET["name"]){
            if(mysqli_num_rows($result) == 0){
                echo "<button type='submit' class='btn btn-primary'><i class='fas fa-exclamation-circle'></i></button>";
            }else{
                echo "<button type='submit' formaction='unblock.php?userid=" . $otherid . "' class='btn btn-primary'><i class='fas fa-check'></i></button>";
            }
        }
      ?>
  </form>
</div>
</div>
</nav>
<div class="container-fluid" style="padding:2%; text-align: center">
<div class="card-columns">
<?php

$stmt=$conn->prepare("SELECT users.username,tweets.content,tweets.timer FROM tweets INNER JOIN users ON tweets.userid=users.id WHERE users.username = ?");
$stmt->bind_param("s", $_GET["name"]);
$stmt->execute();
$result = $stmt->get_result();

date_default_timezone_set('UTC');
while($row = $result->fetch_assoc()){
    $text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="hashtag.php?tag=$1">#$1</a>', $row["content"]);
    echo "<div class='card text-white bg-primary mb-5' style='max-width: 18rem;'>";
    echo "<div class='card-header'>" . "@" . $row["username"] . "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $text . "</h5>";
    echo "<p>" . date($row["timer"]) . "</p>";
    echo "</div></div>";
}
?>
</div>
</div>
