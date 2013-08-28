<?php
include (__dir__ . '/../SessionHandler.php');

$mysqli = new mysqli('localhost', 'root', 'root', 'session');
$sessiondb = new MysqlSessionDB($mysqli);
$session = new SessionHandler($sessiondb);

session_set_save_handler($session, true);
session_start();

// Store and retrieve session data

session_destroy();
?>
