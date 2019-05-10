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
if ($_SESSION["kyahaiuser"] == "") {
    header("Location:landing.html");
}
include 'credentials.php';

if (!isset($_GET["id"])) {
    $text = $_GET["text"];
    $sql = "SELECT id FROM tweets WHERE content LIKE '%" . $text . "%'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $tweetid = $row["id"];
    }
} else {
    $tweetid = $_GET["id"];
}
?>
<body>
    <?php include "navbar.php" ?>
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
              <form action="makeSolution.php?id=<?php echo $id ?>" enctype='multipart/form-data' method="post">
                  <div class="form-group">
                      <textarea name="tweetMaker" class="form-control" required="required"></textarea>
                  </div>
                  <center>
                       <table id="table" width="100%">
                           <thead>
                               <tr class="text-center">
                                   <th colspan="3" style="height:50px;">Add Supporting Files</th>
                               </tr>
                           </thead>
                           <tbody>
                               <tr class="add_row"><td>#</td><td><input name="files[]" type="file" multiple /></td><tr>
                           </tbody>
                           <tfoot>
                               <tr class="last_row">
                                   <td colspan="4" style="text-align:center;">
                                       <button class="btn btn-primary submit float-right" name="btnSubmit" type='submit'>Create</button>
                                   </td>
                               </tr>
                           </tfoot>
                       </table>
                   </center>
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
                    $stmt->bind_param("i", $tweetid);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($row = $result->fetch_assoc()) {
                        echo $row["content"];
                    }
                ?>
            </h1>
        </div>
    </div>
</div>
        </div>
    </div>
    <div class="container-fluid" style="padding: 2%;text-align: center">
    <div class="card-columns">
    <?php
    $sql = $conn->prepare("SELECT users.username,replies.content,replies.timer,replies.id FROM replies INNER JOIN users ON replies.userid=users.id WHERE replies.tweetid=?");
    $sql->bind_param("i", $tweetid);
    $sql->execute();
    $result = $sql->get_result();

    date_default_timezone_set('UTC');
    if (mysqli_num_rows($result) == 0) {
        echo "</div><h1 class='display-4'>No Solutions Yet!</h1>";
    } else {
        while ($row = $result->fetch_assoc()) {
            $text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="hashtag.php?tag=$1">#$1</a>', $row["content"]);
            $text = preg_replace('/(?<!\S)@([0-9a-zA-Z]+)/', '<a href="user.php?name=$1">@$1</a>', $text);
            echo "<div class='card text-primary bg-light mb-5' style='max-width: 18rem;'>";
            $id = $row["id"];
            echo "<div class='card-header'><form style='display: inline;' action='vote.php?reply=" . $id . "'method='POST'><button class='btn btn-secondary' type='submit'>";
            echo "<i class='fas fa-thumbs-up'></i></button></form><a class='text-primary' style='padding:10%' href='user.php?name=" . $row["username"] . "'>" . "@" . $row["username"] . "</a>";
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
function loadDynamicContent(text){
    window.location.href = "getFullContent.php?modal=" + text;
}
</script>
