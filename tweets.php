<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<style>
a:link { color: white; text-decoration: none}
a:visited { color: white; text-decoration: none}
a:hover { color: white; text-decoration: none}
a:active { color: white; text-decoration: none}
</style>
<?php
session_start();
if($_SESSION["kyahaiuser"] == ""){
    header("Location:landing.html");
}

$id = $_GET["id"];

include 'credentials.php';
?>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand">
            <?php
                  echo "Welcome @" . $_SESSION["kyahaiuser"];
            ?>
        </a>
        <form class="form-inline">
            <?php
                echo "<div class='btn-group' role='group' aria-label='Basic example'><button type='button' class='btn btn-secondary'><a href='home.php'><i class=
                'fas fa-home'></i></a></button><button type='button' data-toggle='modal' data-target='#followingModal' class='btn btn-secondary'>";
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
      </nav>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Pitch Solution!</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="makeSolution.php?id=<?php echo $id ?>" method="post">
                  <div class="form-group">
                      <textarea name="tweetMaker" class="form-control" required="required"></textarea>
                  </div>
                  <button class="btn btn-primary float-right"type="submit">Create</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-3" style="text-align: center">
                <?php
                    $stmt=$conn->prepare("SELECT tweets.content FROM tweets WHERE tweets.id = ?");
                    $stmt->bind_param("s",$id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while($row = $result->fetch_assoc()){
                        echo $row["content"];
                    }
                ?>
            </h1>
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
              <div class="card-group">
              <?php
                  $sql = "SELECT users.id,users.username FROM users INNER JOIN followers ON followers.followee=users.id";
                  $result = $conn->query($sql);
                  while($row = $result->fetch_assoc()){
                      echo "<div class='card text-white bg-primary mb-5' style='max-width: 18rem;'>";
                      echo "<div class='card-header'><a style='color:white' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></div>";
                      echo "<div class='card-body'>";
                      echo "<h5 class='card-title'><a href='unfollow.php?user=" . $row["id"] . "'><button class='btn btn-secondary'>Unfollow</button></a></h5>";
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
                <div class="card-group">
                <?php
                  $sql = "SELECT users.id,users.username FROM users INNER JOIN followers ON followers.follower=users.id";
                    $result = $conn->query($sql);
                    while($row = $result->fetch_assoc()){
                        echo "<div class='card text-white bg-primary mb-5' style='max-width: 18rem;'>";
                        echo "<div class='card-header'><a style='color:white' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></div>";
                        echo "<div class='card-body'>";
                        echo "<h5 class='card-title'><a href='unfollow.php?user=" . $row["id"] . "'><button class='btn btn-secondary'>Unfollow</button></a></h5>";
                        echo "</div></div>";
                    }
                ?>
            </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="fullModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Full Solution</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
      <div id="modalcontent" style="word-break: break-word " class="modal-body display-4">
      </div>
</div>
        </div>
    </div>
    <div class="container-fluid" style="padding: 2%;text-align: center">
    <div class="card-columns">
    <?php
    $sql = $conn->prepare("SELECT users.username,replies.content,replies.timer,replies.id FROM replies INNER JOIN users ON replies.userid=users.id WHERE replies.tweetid=?");
    $sql->bind_param("s",$id);
    $sql->execute();
    $result = $sql->get_result();

    date_default_timezone_set('UTC');
    if(mysqli_num_rows($result) == 0){
            echo "</div><h1 class='display-4'>No Solutions Yet!</h1>";
    }else{
    while($row = $result->fetch_assoc()){
            $text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="hashtag.php?tag=$1">#$1</a>', $row["content"]);
            $text = preg_replace('/(?<!\S)@([0-9a-zA-Z]+)/', '<a href="user.php?name=$1">@$1</a>', $text);
            echo "<div class='card text-white bg-primary mb-5' style='max-width: 18rem;'>";
            $id = $row["id"];
            echo "<div class='card-header'><form style='display: inline;' action='vote.php?reply=" . $id . "'method='POST'><button class='btn btn-secondary' type='submit'>";
            echo "<i class='fas fa-thumbs-up'></i></button></form><a style='color:white; padding:10%' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a>";
            echo "<button type='button' class='btn btn-secondary' onclick='loadDynamicContent(" . $row["id"] . ")'><i class='fas fa-expand'></i></button>";
            echo "</div>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $row["content"] . "</h5>";
            echo "</div>";
            echo "<div class='card-footer text-muted'>" . date($row["timer"]) . "</div></div>";
    }
}
    ?>
    </div>
</body>
<script>
$(document).ready(function(){
    $(".card-title").each(function(i){
      len = $(this).text().length;
      if(len>20)
      {
        $(this).text($(this).text().substr(0,20)+"...");
      }
    });
});

function loadDynamicContent(modal) {
		var options = {
			modal : true,
			height : 300,
			width : 500
		};
		$('#modalcontent').load('getFullContent.php?modal=' + modal,
				function() {
					$('#fullModal').modal({
						show : true
					});
				});
            }
</script>
