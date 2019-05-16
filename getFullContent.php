<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/main.css">
</head>
<?php
session_start();
if($_SESSION["kyahaiuser"] == ""){
    header("Location:landing.html");
}

$solutionid = $_GET["modal"];

include 'credentials.php';
?>
<body>
    <?php include "navbar.php" ?>
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Write Comment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="makeComment.php?id=<?php echo $id ?>" method="post">
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
                    $stmt=$conn->prepare("SELECT replies.content FROM replies WHERE replies.id = ?");
                    $stmt->bind_param("i",$solutionid);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while($row = $result->fetch_assoc()){
                        echo $row["content"];
                    }
                    $sql = $conn->prepare("SELECT * FROM fileuploads WHERE solutionid = ?");
                    $sql->bind_param("i", $solutionid);
                    $sql->execute();
                    $result = $sql->get_result();
                ?>
            </h1>
            <table class="table">
                <h3>Supporting Evidence</h3>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
  <?php
  	while($r = $result->fetch_assoc()){
   ?>
    <tr>
      <td><?php echo $r['name'] ?></td>
      <td><a href="<?php echo $r['name'] ?>">View</a></td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</table>
        </div>
    </div>
    </div>
    <div class="container-fluid" style="padding: 2%;text-align: center">
    <div class="card-columns">
    <?php

    $sql = $conn->prepare("SELECT users.username,comments.content,comments.timer,comments.id FROM comments INNER JOIN users ON comments.userid=users.id WHERE comments.replyid=?");
    $sql->bind_param("i",$id);
    $sql->execute();
    $result = $sql->get_result();

    date_default_timezone_set('UTC');
    if(mysqli_num_rows($result) == 0){
            echo "</div><h1 class='display-4'>No Comments Yet!</h1>";
    }else{
    while($row = $result->fetch_assoc()){
            $text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="hashtag.php?tag=$1">#$1</a>', $row["content"]);
            // $text = preg_replace('/(?<!\S)@([0-9a-zA-Z]+)/', '<a href="user.php?name=$1">@$1</a>', $text);
            echo "<div class='card text-primary bg-light mb-5' style='max-width: 18rem;'>";
            $id = $row["id"];
            echo "<div class='card-header'>";
            echo "<a class='text-primary' style='padding:10%' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a>";
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
function loadDynamicContent(text){
    window.location.href = "getFullContent.php?modal=" + text;
}
</script>
