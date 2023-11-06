<?php
    include_once '../sessioncheck.php';  
    // print_r($_POST);
    $payload = [];
    $polygon = [];
    $c = $_POST['contador'];
    $name = '';

    if(isset($_POST['var'])){
        $variaveis = $_POST['var'];    
        for($i=0; $i<count($variaveis); $i++){
            $name .= $variaveis[$i];
        }
    $payload += ['name' => $name];
    }
    
    if ($_POST['fim'] != ''){
        $payload += ['date-max' => $_POST['fim']];
    }

    if ($_POST['inicio'] != ''){
        $payload+= ['date-min' => $_POST['inicio']];
    }

    for($i=1; $i<=$c; $i++){
        $cordenada = array(
            'latitude' => $_POST["lat$i"],
            'longitude' => $_POST["lng$i"]
        );
        $polygon[] = $cordenada;
    }
    if(!empty($polygon)){
        $payload += ['polygon' => $polygon];
    }
    $payload += ['authToken' => $_SESSION['token']]; 
    // $payload += ['cross_secret' => $_ENV['CROSS_SERVER_SECRET']];
    echo json_encode($payload);
?>