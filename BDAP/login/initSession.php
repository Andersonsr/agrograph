<?php
    session_start();
    error_reporting(0);
    $_SESSION['email'] = $_POST['email'];
    echo(1);
?>
