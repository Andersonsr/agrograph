<?php
    error_reporting(0);
    ini_set('display_errors', 0);
    if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["contra"]) && !empty($_POST["contra"])){
        include_once '../connect.php';
        session_start();
       
        $email = $_POST["email"];
        $query = "MATCH (user{ email: '" . $email . "' }) RETURN user.email";
        $result = $client->run($query);
        
        $login = 0;
        
        foreach($result as $r){
            if ($r->get('user.email') == $email){
                $login = 1;
                $_SESSION["email"] = $email;
            }
        }

        if ($login == 0){
            echo 0;
        }

        if ($login == 1){
            $query = "MATCH (user{ email: '" . $email . "' }) RETURN user.contra as pwd, id(user) as id";
            $result = $client->run($query);
            
            foreach($result as $r){
                 
                if (password_verify($_POST['contra'], $r->get("pwd"))){
                    $login = 2;
                    $_SESSION["contra"] = $r->get("pwd");
                    $_SESSION["id"] = $r->get("id");
                    echo 2;
                }
            }
            if ($login == 1){
                echo 1;
            }
        }
    }
?>
