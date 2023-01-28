<?php
    error_reporting(1);
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    echo var_dump($_POST);
    
    if (isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["contra1"]) && !empty($_POST["contra1"]) && isset($_POST["nombre"]) && !empty($_POST["nombre"]) && isset($_POST["inst"]) && !empty($_POST["inst"]) && isset($_POST["contra2"]) && !empty($_POST["contra2"])){
        include_once '../connect.php';
        $name = $_POST["nombre"];
        $email = $_POST["email"];
        $inst = $_POST["inst"];
        
        $hash = password_hash($_POST['contra1'], PASSWORD_BCRYPT);

        if (password_verify($_POST['contra2'], $hash)){
            $query = "MATCH (user:User) WHERE user.email = $email RETURN user";
            $result = $client->run($query);
            
            if (!count($result)){
                $query = "CREATE (user:User {name:'$name', email:'$email', contra:'$hash', institucao:'$inst'}) RETURN user";
                $client->run($query);
                // ok
                echo 1;
            }
            else{
                // email ja cadastrado
                echo 0;
            }
            
        }else{
            // senhas diferentess
            echo 2;
        }  
    }   
?>