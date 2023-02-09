<?php
    require_once '../../composer/vendor/autoload.php';
    use Laudis\Neo4j\Authentication\Authenticate;
    use Laudis\Neo4j\ClientBuilder;
    
    error_reporting(0);
    // ini_set('display_errors', 1);
    // error_reporting(E_ALL);

    $client = ClientBuilder::create()
        ->withDriver('default', 'bolt://neo4j:12345678@neo4j:7687') 
        ->withDefaultDriver('default')
        ->build();
    
?>

