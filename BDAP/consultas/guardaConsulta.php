<?php
    include_once '../sessioncheck.php';  
    print_r($_POST);
    if(isset($_POST['data'])){
        $_SESSION['data'] = json_decode($_POST['data']);
        echo 'ok';
    }
    echo 'erro';
?>