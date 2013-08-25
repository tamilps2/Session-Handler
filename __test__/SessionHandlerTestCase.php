<?php
include (__dir__ . '/../HB_SessionHandler.php');

$mysqli = new mysqli('localhost', 'root', 'root', 'hbsession');
$sessiondb = new MysqlSessionDB($mysqli);
$session = new HB_SessionHandler($sessiondb);

session_set_save_handler($session, true);
session_start();

// Store and retrieve session data

session_destroy();
?>