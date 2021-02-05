<?php
include 'core/class/include.php';

// Redirige l'utilisateur si il est connecté
if (Account::isAuthentified())
{
    header('Location: dashboard.php');
}

// Action: Login
if (isset($_POST['connexion']))
{
    $no_error = Account::Auth($_POST['username'], $_POST['password']);
    if ($no_error == true)
    {
        header('Location: dashboard.php');
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>GET OUT</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<body>
    <!--<?php include('includes/navbar.php'); ?> -->
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title text-center">STOP</h3>
                  </div>
                  <div class="panel-body">
                        <?php if (isset($no_error)) { ?>
                            <div class="alert alert-danger text-center" role="alert"><strong>Damn, Error:</strong> Your username or password is incorrect.</div>
                        <?php } ?>
                        <form method="POST" action="#">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control" name="username" placeholder="Username">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Password">
                          </div>
                          <button type="submit" name="connexion" class="center-block btn btn-default">Login me in plz</button>
                        </form>
                  </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
</body>
    
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</html>