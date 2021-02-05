<?php
include 'core/class/include.php';
Account::Disconnect();
header('Location: index.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<title>Logging out.</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
</head>

<body>
    <br>
    <h1>Logging you out...</h1>
</body>
    
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
</html>