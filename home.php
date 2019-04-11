<?php
    session_start();
    if($_SESSION["kyahaiuser"] == ""){
        header("Location:landing.html");
    }

    include 'credentials.php';

?>
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
    a:link { color: white; text-decoration: none}
a:visited { color: white; text-decoration: none}
a:hover { color: white; text-decoration: none}
a:active { color: white; text-decoration: none}
    </style>
</head>
<nav class="navbar navbar-light bg-light fixed-top">
    <div class="container-fluid">
    <a class="navbar-brand">
        <?php
              echo "Welcome @" . $_SESSION["kyahaiuser"];
        ?>
    </a>
  <form class="form-inline">
    <?php
        echo "<div class='btn-group' role='group' aria-label='Basic example'><button type='button' data-toggle='modal' data-target='#followingModal' class='btn btn-secondary'>";
        $sql = "SELECT COUNT(followers.followee) FROM followers WHERE followers.followee!=" . $_SESSION["myID"];
        $result = $conn->query($sql);

        while($row = $result->fetch_array()){
            echo $row[0];
        }

        echo " Following</button>";

        echo "<button type='button' class='btn btn-secondary' data-toggle='modal' data-target='#followerModal'>";
        $sql = "SELECT COUNT(followers.followee) FROM followers WHERE followers.followee=" . $_SESSION["myID"];
        $result = $conn->query($sql);

        while($row = $result->fetch_array()){
            echo $row[0];
        }

        echo " Followers</button>";
    ?>
    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" type="button"><i class="fas fa-plus"></i></button>
    <button class="btn btn-success" type="button"><a href="logout.php"><i class="fas fa-sign-out-alt"></i></a></button>
</div>
  </form>
</div>
</nav>
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
<div class="modal fade" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">I'm Following</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="card-deck" style="display: inline-flex">
          <?php
              $sql = "SELECT users.id,users.username FROM users INNER JOIN followers ON followers.followee=users.id WHERE users.id <> " . $_SESSION["myID"];
              $result = $conn->query($sql);
              while($row = $result->fetch_assoc()){
                  echo "<div class='card text-white bg-primary mb-5' style='max-width: 18rem;'>";
                  // echo "<div class='card-header'><a style='color:white' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></div>";
                  echo "<div class='card-body'>";
                  echo "<h5 class='card-title'><a style='color:white' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></h5><a href='unfollow.php?user=" . $row["id"] . "'><button class='btn btn-secondary'>Unfollow</button></a>";
                  echo "</div></div>";
              }
          ?>
      </div>
  </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="followerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">My Followers</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="card-deck" style="display: inline-flex">
            <?php
              $sql = "SELECT users.id,users.username FROM users INNER JOIN followers ON followers.follower=users.id WHERE users.id <>" . $_SESSION["myID"];
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()){
                    echo "<div class='card text-white bg-primary mb-5' style='max-width: 18rem;'>";
                    echo "<div class='card-body'><h5 class='card-title'><a style='color:white' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></h5></div>";
                    //echo "<div class='card-body'>";
                    //echo "<h5 class='card-title'><a href='unfollow.php?user=" . $row["id"] . "'><button class='btn btn-secondary'>Unfollow</button></a></h5>";
                    echo "</div>";
                }
            ?>
        </div>
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
$sql = "SELECT tweets.id,users.username,tweets.content,tweets.timer FROM tweets INNER JOIN users ON tweets.userid=users.id INNER JOIN followers ON users.id=followers.followee WHERE users.id !=" . $_SESSION["myID"] . " ORDER BY tweets.timer DESC";
// this is just a string

$result = $conn->query($sql);
date_default_timezone_set('UTC');
while($row = $result->fetch_assoc()){
    $text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="hashtag.php?tag=$1">#$1</a>', $row["content"]);
    $text = preg_replace('/(?<!\S)@([0-9a-zA-Z]+)/', '<a href="user.php?name=$1">@$1</a>', $text);
    echo "<div class='card text-white bg-primary mb-5' style='max-width: 18rem;'>";
    echo "<div class='card-header'><a style='color:white' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $text . "</h5>";
    echo "<p>" . date($row["timer"]) . "</p>";
    echo "<a style='color:white' href='tweets.php?id=" . $row["id"] . "'>See Full</a>";
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
$sql = "SELECT tweets.id,users.username,tweets.content,tweets.timer FROM tweets INNER JOIN users ON tweets.userid=users.id ORDER BY tweets.timer DESC";
// this is just a string

$result = $conn->query($sql);
date_default_timezone_set('UTC');
while($row = $result->fetch_assoc()){
    $text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="hashtag.php?tag=$1">#$1</a>', $row["content"]);
    $text = preg_replace('/(?<!\S)@([0-9a-zA-Z]+)/', '<a href="user.php?name=$1">@$1</a>', $text);
    echo "<div class='card text-white bg-primary mb-5' style='max-width: 18rem;'>";
    echo "<div class='card-header'><a style='color:white' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . $text . "</h5>";
    echo "<p>" . date($row["timer"]) . "</p>";
    echo "<a style='color:white' href='tweets.php?id=" . $row["id"] . "'>See Full</a>";
    echo "</div></div>";
}

?>
</div>
</div>
