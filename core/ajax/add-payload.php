<?php
header('Content-Type: application/json');
include('../class/include.php');
if (!Account::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

$content = str_replace("<NEWLINE>", "\n", $_POST['content']);
Payload::CreatePayload($_POST['name'], $_POST['comment'], $content);
?>