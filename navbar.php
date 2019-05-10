<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <?php
              echo "<a class='navbar-brand' href='user.php?name=" . $_SESSION["kyahaiuser"] . "'>Welcome @" . $_SESSION["kyahaiuser"] . "</a>";
        ?>
      <div class='btn-group' role='group' aria-label='Basic example'>
    <?php
        $id = $_SESSION["myID"];
        include "getFollowDetails.php";
    ?>
    <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" type="button"><i class="fas fa-plus"></i></button>
    <button class="btn btn-success" type="button"><a href="logout.php"><i class="fas fa-sign-out-alt"></i></a></button>
</div>
<div class="input-group mb-2" style="width: auto;">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fas fa-search"></i></div>
        </div>
      <input type="text" name="typeahead" id="search" autocomplete="off">
      </div>
</div>
</nav>
