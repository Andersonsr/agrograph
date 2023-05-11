<?php
    session_start();
    error_reporting(0);
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['token'] = $_POST['token'];
    echo(1);
?>
