<?php
    require_once '../../composer/vendor/autoload.php';
    use Laudis\Neo4j\Authentication\Authenticate;
    use Laudis\Neo4j\ClientBuilder;
    $password = $_ENV['NEO4J_PASSWORD'];
    $user = $_ENV['NEO4J_USER'];
    $host = $_ENV['NEO4J_HOST'];
    error_reporting(0);
    // ini_set('display_errors', 1);
    // error_reporting(E_ALL);

    $client = ClientBuilder::create()
        ->withDriver('default', "bolt://$user:$password@$host:7687") 
        ->withDefaultDriver('default')
        ->build();
    
?>

