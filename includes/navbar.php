<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
        <a class="navbar-brand" href="#"><img src="images/wicon.png"></a>
    </div>

    <div class="collapse navbar-collapse" aria-expanded="true">
        <ul class="nav navbar-nav navbar-right">
            <?php if (!Account::isAuthentified()) { ?>
            <?php } else { ?>
                <li><a href="logout.php"><i class="fa fa-user-times"></i></a></li>
            <?php } ?>
        </ul>
    </div>
  </div>
</nav>