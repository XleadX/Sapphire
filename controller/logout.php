<?php
session_start();
$username = $_SESSION['username'];

require_once('../setting/connection.php');

unset($_SESSION['username'], $_SESSION['email'], $_SESSION['time']);
session_destroy();

header('location:../index.php');
?>