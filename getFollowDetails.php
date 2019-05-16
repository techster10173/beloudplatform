<?php
    echo "<button type='button' class='btn btn-secondary'><a href='home.php' style='color: white'><i class=
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

    if($id == $_SESSION["myID"]){
        $sql = "SELECT COUNT(block.blocker) FROM block WHERE block.blocker =" . $id;
        $result = $conn->query($sql);

        echo "<button type='button' class='btn btn-secondary' data-toggle='modal' data-target='#blockedModal'>";
        while ($row = $result->fetch_array()) {
            echo $row[0];
        }
        echo " Blocked</button>";
    }
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
          <table class="table table-striped">
          <?php
          /*Prepared Statement*/
              $sql = "SELECT users.id,users.username FROM users INNER JOIN followers ON followers.followee=users.id WHERE followers.follower =" . $id;
              $result = $conn->query($sql);
              while ($row = $result->fetch_assoc()) {
                  $query = "SELECT followers.follower FROM followers WHERE followers.follower = " . $id . " AND followers.followee = " . $row["id"];
                  $test = $conn->query($query);
                  echo "<tr>";
                  echo "<td style='vertical-align: inherit'><a href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></td>";
                  if($row["id"] == $_SESSION["myID"]){

                  }else if(mysqli_num_rows($test) == 0){
                      echo "<td><a style='float:right' href='follow.php?userid=" . $row["id"] . "'><button class='btn btn-secondary'>Follow</button></a></td>";
                  }else{
                      echo "<td><a style='float:right' href='unfollow.php?userid=" . $row["id"] . "'><button class='btn btn-secondary'>Unfollow</button></a></td>";
                  }
                  echo "</tr>";
              }
          ?>
      </table>
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
          <table class="table table-striped">
            <?php
            /*Prepared Statement*/
                $sql = "SELECT users.id,users.username FROM users INNER JOIN followers ON followers.follower=users.id WHERE followers.followee =" . $id;
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    $query = "SELECT followers.follower FROM followers WHERE followers.follower = " . $id . " AND followers.followee = " . $row["id"];
                    $test = $conn->query($query);
                    echo "<tr>";
                    echo "<td style='vertical-align: inherit'><a href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></td>";
                    if($row["id"] == $_SESSION["myID"]){

                    }else if(mysqli_num_rows($test) == 0){
                        echo "<td><a style='float:right' href='follow.php?userid=" . $row["id"] . "'><button class='btn btn-secondary'>Follow</button></a></td>";
                    }else{
                        echo "<td><a style='float:right' href='unfollow.php?userid=" . $row["id"] . "'><button class='btn btn-secondary'>Unfollow</button></a></td>";
                    }
                    echo "</tr>";
                }
            ?>
        </table>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="blockedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">I Blocked</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <table class="table table-striped">
            <?php
            /*Prepared Statement*/
                $sql = "SELECT users.id,users.username FROM users INNER JOIN block ON block.blockee=users.id WHERE block.blocker =" . $id;
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td style='vertical-align: inherit'><a href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a></td>";
                    echo "<td><a style='float:right' href='unblock.php?userid=" . $row["id"] . "'><button class='btn btn-secondary'>Unblock</button></a></td>";
                    echo "</tr>";
                }
            ?>
        </table>
        </div>
      </div>
    </div>
  </div>
