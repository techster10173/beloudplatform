<?php
    echo "<button type='button' class='btn btn-secondary'><a href='home.php'><i class=
    'fas fa-home'></i></a></button><button type='button' data-toggle='modal' data-target='#followingModal' class='btn btn-secondary'>";
    /*Prepared Statement*/
    $sql = "SELECT COUNT(followers.follower) FROM followers WHERE followers.follower=" . $id;
    $result = $conn->query($sql);

    while ($row = $result->fetch_array()) {
        echo $row[0];
    }

    echo " Following</button>";

    echo "<button type='button' class='btn btn-secondary' data-toggle='modal' data-target='#followerModal'>";
    /*Prepared Statement*/
    $sql = "SELECT COUNT(followers.followee) FROM followers WHERE followers.followee=" . $id;
    $result = $conn->query($sql);

    while ($row = $result->fetch_array()) {
        echo $row[0];
    }

    echo " Followers</button>";

    $sql = "SELECT COUNT(votes.userid) FROM votes WHERE votes.userid =" . $id;
    $result = $conn->query($sql);

    echo "<button type='button' class='btn btn-secondary'>";
    while ($row = $result->fetch_array()) {
        echo $row[0];
    }
    echo " Up Votes</button>";
?>
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
          /*Prepared Statement*/
              $sql = "SELECT users.id,users.username FROM users INNER JOIN followers ON followers.followee=users.id WHERE followers.follower =" . $id;
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
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
            /*Prepared Statement*/
              $sql = "SELECT users.id,users.username FROM users INNER JOIN followers ON followers.follower=users.id WHERE followers.followee =" . $id;
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
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
