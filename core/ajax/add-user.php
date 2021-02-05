<?php
include('../class/include.php');
if (!Account::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

echo Account::CreateUser($_GET['username'], $_GET['password'], $_GET['cpassword']);
?>