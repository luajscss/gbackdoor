<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
date_default_timezone_set('US/Pacific');
include 'Config.php';
include 'Database.php';
include 'CSRF.php';
include 'Account.php';
include 'Server.php';
include 'Payload.php';
include 'Logs.php';
include 'Params.php';

$GLOBALS['DB'] = new Database($GLOBALS['mysql_host'], $GLOBALS['mysql_database'], $GLOBALS['mysql_username'], $GLOBALS['mysql_password']);
?>