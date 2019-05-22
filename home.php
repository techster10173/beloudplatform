<?php
    session_start();
    if ($_SESSION["kyahaiuser"] == "") {
        header("Location:index.html");
    }

    include 'credentials.php';
?>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script
      src="https://code.jquery.com/jquery-3.4.1.js"
      integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
      crossorigin="anonymous"></script>    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<?php include "navbar.php" ?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Identify Problem!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="makeTweet.php" method="post">
            <div class="form-group">
                <textarea name="tweetMaker" class="form-control"></textarea>
            </div>
            <button class="btn btn-primary float-right" type="submit">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid" style="padding: 2%">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h2 class="display-4">I'm Interested In...</h2>
      </div>
    </div>
<div class="card-columns" style="text-align: center">
<?php
/*Prepared Statement*/
$sql = $conn->prepare("SELECT tweets.id,users.username,tweets.content,tweets.timer FROM followers INNER JOIN tweets ON tweets.userid = followers.followee INNER JOIN users ON users.id = tweets.userid WHERE followers.follower = ? AND tweets.userid NOT IN (SELECT block.blocker FROM block WHERE block.blockee=?)");
$sql->bind_param("ii",$_SESSION["myID"],$_SESSION["myID"]);
$sql->execute();
$result = $sql->get_result();

date_default_timezone_set('UTC');
while ($row = $result->fetch_assoc()) {
    $text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="hashtag.php?tag=$1">#$1</a>', $row["content"]);
    // $text = preg_replace('/(?<!\S)@([0-9a-zA-Z]+)/', '<a href="user.php?name=$1">@$1</a>', $text);
    echo "<div class='card text-primary bg-light mb-5' style='max-width: 18rem;'>";
    echo "<div class='card-header'><a class='text-primary' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $text . "</h5>";
    echo "<p>" . date($row["timer"]) . "</p>";
    echo "<button class='btn btn-primary'><a style='color:white' href='tweets.php?id=" . $row["id"] . "'>See Full</a></button>";
    echo "</div></div>";
}

?>
</div>
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h2 class="display-4">All Problems...</h2>
  </div>
</div>
<div class="card-columns" style="text-align: center">
<?php
/*Prepared Statement*/
$sql = $conn->prepare("SELECT tweets.id,users.username,tweets.content,tweets.timer FROM tweets INNER JOIN users ON tweets.userid=users.id WHERE tweets.userid NOT IN (SELECT block.blocker FROM block WHERE block.blockee=?)");
$sql->bind_param("i",$_SESSION["myID"]);
$sql->execute();
$result = $sql->get_result();
//ORDER BY tweets.timer
date_default_timezone_set('UTC');
while ($row = $result->fetch_assoc()) {
    $text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="hashtag.php?tag=$1">#$1</a>', $row["content"]);
    echo "<div class='card text-primary bg-light mb-5' style='max-width: 18rem;'>";
    echo "<div class='card-header'><a class='text-primary' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $text . "</h5>";
    echo "<p>" . date($row["timer"]) . "</p>";
    echo "<button class='btn btn-primary'><a style='color:white' href='tweets.php?id=" . $row["id"] . "'>See Full</a></button>";
    echo "</div></div>";
}

?>
</div>
</div>
