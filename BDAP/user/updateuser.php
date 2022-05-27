<?php
    error_reporting(0);
    ini_set('display_errors', 0);
    include_once '../sessioncheck.php';

    if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["contra"]) && !empty($_POST["contra"]) && isset($_POST["nombre"]) && !empty($_POST["nombre"]) && isset($_POST["inst"]) && !empty($_POST["inst"])){
        include_once '../connect.php';

        $name = $_POST["nombre"];
        $email = $_POST["email"];
        $contra = $_POST["contra"];
        $inst = $_POST["inst"];
        $hash = password_hash($contra, PASSWORD_BCRYPT);

        session_start();
        $query = "MATCH (user{ email: '" . $email . "' }) RETURN user.email";

        $result = $client->run($query);
       
        $insert = 0;

        foreach($result as $r){
            if ($r->get('user.email') == $email && $email != $_SESSION["email"]){
                $insert = 1;
            }
        }

        if ($insert == 0){
            echo 0;
            $query = "MATCH (user{ email: '" . $_SESSION["email"] . "' }) SET user.name = '" . $name . "', user.email = '" . $email . "', user.contra = '" . $hash . "', user.institucao = '" . $inst . "' RETURN user.name";
            $client->run($query);
            $_SESSION["email"] = $email;
            $_SESSION["contra"] = $hash;
        } if ($insert == 1){
            echo 1;
        }
    }

    
