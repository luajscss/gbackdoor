<?php
include('../class/include.php');
if (!Account::isAuthentified() || !CSRF::isAjaxRequest())
{
    die("Bad request");
}

$content = str_replace("<NEWLINE>", "\n", $_POST['content']);
Payload::EditPayload($_GET['id'], $_POST['name'], $_POST['comment'], $content);
?>