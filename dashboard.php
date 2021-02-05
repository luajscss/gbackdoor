<?php
include 'core/class/include.php';

// Redirect the user if he does not authenticate
if (!Account::isAuthentified())
{
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>Dashboard</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<body>
    <?php include('includes/navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="col-md-2">
                <ul class="nav nav-pills nav-stacked">
                  <li class="active"><a data-toggle="tab" href="#logs"><i class="fa fa-list-alt"></i>&nbsp;Logs</a></li>
                  <li><a data-toggle="tab" href="#server"><i class="fa fa-server"></i>&nbsp;Servers</a></li>
                  <li><a data-toggle="tab" href="#users"><i class="fa fa-user"></i>&nbsp;User</a></li>
                  <li><a data-toggle="tab" href="#payload"><i class="fa fa-file-code-o"></i>&nbsp;Payload</a></li>
                  <li><a data-toggle="tab" href="#obfuscation"><i class="fa fa-cogs"></i>&nbsp;Obfuscation (Its shit)</a></li>
                  <li><a data-toggle="tab" href="#params"><i class="fa fa-wrench"></i>&nbsp;Parameters (what?)</a></li>
                </ul>
            </div>
            
            <div class="col-md-10">
                <div class="tab-content">
                  <?php include('includes/logs.php'); ?>
                  <?php include('includes/server.php'); ?>
                  <?php include('includes/users.php'); ?>
                  <?php include('includes/payload.php'); ?>
                  <?php include('includes/obfuscation.php'); ?>
                  <?php include('includes/params.php'); ?>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</html>