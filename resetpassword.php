<?php
include 'core/class/include.php';

// Redirige l'utilisateur si il est connecté
if (Account::isAuthentified())
{
    header('Location: dashboard.php');
}

// Action: Connexion
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
	<title>Disabled</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<body>
    <?php include('includes/navbar.php'); ?>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h1>This page has been disabled by the author</h1>
</body>
    
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</html>