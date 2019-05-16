    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>
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
    <button class="btn btn-success" type="button"><a href="logout.php" style="color: white"><i class="fas fa-sign-out-alt"></i></a></button>
</div>
<div class="input-group mb-2" style="width: auto;">
        <div class="input-group-prepend">
          <div class="input-group-text"><i class="fas fa-search"></i></div>
        </div>
      <input type="text" name="typeahead" id="search" autocomplete="off">
      </div>
</div>
</nav>
<script>
    $(document).ready(function(){
        $('#search').typeahead({
            source:  function (query, process){ //function that runs when search input is being typed
              $.ajax({
                  //sends query to search.php through GET
                  url: "search.php?query=" + query,
                  data: "json",
                  type: "GET",
                  success: function(data){
                      //returns the data from search.php
                      data = $.parseJSON(data); //decodes json
        	          return process(data);
                  }
              });
          },
      });
  });
  $("#search").keypress(function (e) {
    if (e.which == 13) {
        event.preventDefault();
        if($("#search").val().charAt(0) == "@"){
            window.location.replace("user.php?name=" + $("#search").val().substring(1));
        }else{
            window.location.replace("tweets.php?text=" + $("#search").val());
        }
    }
});
    </script>
