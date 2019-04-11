<?php
include 'credentials.php';

$query = "SELECT replies.content,COUNT(votes.replyid) FROM replies INNER JOIN votes ON replies.id=votes.replyid WHERE replies.id =" . $_GET["modal"];
$result = $conn->query($query);

while($row = $result->fetch_assoc()){
    $text = preg_replace('/(?<!\S)#([0-9a-zA-Z]+)/', '<a href="hashtag.php?tag=$1">#$1</a>', $row["content"]);
    $text = preg_replace('/(?<!\S)@([0-9a-zA-Z]+)/', '<a href="user.php?name=$1">@$1</a>', $text);
    echo "<div class='modal-text' style='display: inline'>";
    echo $text;
    echo "</div>";
    echo "<form style='display: inline;padding: 2%' action='vote.php?reply=" . $_GET["modal"] . "'method='POST'><button class='btn btn-secondary' type='submit'>";
    echo "<i class='fas fa-thumbs-up'></i>" . " " . $row["COUNT(votes.replyid)"] ."</button></form>";
}
?>
