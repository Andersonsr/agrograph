<?php
    error_reporting(0);
    ini_set('display_errors', 0);
    if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["contra1"]) && !empty($_POST["contra1"]) && isset($_POST["nombre"]) && !empty($_POST["nombre"]) && isset($_POST["inst"]) && !empty($_POST["inst"]) && isset($_POST["contra2"]) && !empty($_POST["contra2"])){
        include_once '../connect.php';
        $name = $_POST["nombre"];
        $email = $_POST["email"];
        $inst = $_POST["inst"];
        
        $hash = password_hash($_POST['contra1'], PASSWORD_BCRYPT);

        if (password_verify($_POST['contra2'], $hash)){
            $query = 'MATCH (user:User) RETURN user.email as email';
            $result = $client->run($query);
            $insert = 0;
            
            foreach ($result as $r){
                if ($r->get('email') == $email){
                    $insert = 1;
                }
            }
            
            if ($insert == 0){
                echo 0;
                $query = "CREATE (user:User {name:'$name', email:'$email', contra:'$hash', institucao:'$inst'}) RETURN user";
                $client->run($query);
            }
            else if ($insert == 1){
                echo 1;
            } 
            
        }else{
            echo 2;
        }  
    } else {
        echo 3;
    }

    
