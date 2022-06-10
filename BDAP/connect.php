<?php
    require_once '../../composer/vendor/autoload.php';
    use Laudis\Neo4j\Authentication\Authenticate;
    use Laudis\Neo4j\ClientBuilder;
    
    $client = ClientBuilder::create()
        ->withDriver('bolt', 'bolt://neo4j:pwdneo4j@localhost:7687') 
        ->withDefaultDriver('bolt')
        ->build();
    
?>

