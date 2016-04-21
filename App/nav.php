<?php 
    $uname = $_SESSION["uname"];
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
 
      <!-- Button that toggles the navbar on and off on small screens -->
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
 
      <!-- Hides information from screen readers -->
        <span class="sr-only"></span>
 
        <!-- Draws 3 bars in navbar button when in small mode -->
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
 
      <!-- You'll have to add padding in your image on the top and right of a few pixels (CSS Styling will break the navbar) -->
      <a class="pull-left" href="#"><image src="logo/hangmania_man_and_noose.png" alt="Hangmania Logo" style="cursor:default"></a>
    </div>
 
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="home.php">Home</a></li>
            <li><a href="play.php">Play</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right"><!-- TODO modal -->
            <li><a href="logout.php">Log out</a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
