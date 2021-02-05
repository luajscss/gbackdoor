<?php
include('../class/include.php');
if (!Account::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

Server::CallPayload($_GET['server'], $_GET['payload']);
?>