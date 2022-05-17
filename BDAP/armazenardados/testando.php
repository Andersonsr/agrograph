<?php
echo "<pre>";
include_once '../connect.php';

		
			$latitudebd = 20; 
			$longitudebd = 5;
			//$longitudebd = 5;
			
			$query = "MATCH (l:Localizacao) WHERE l.latitude = $latitudebd AND l.longitude = $longitudebd RETURN id(l)";
            $result = $client->run($query);			
			$records = $result->getRecords();
			print_r($records);
			
			if (!$records){
				echo 'o cara não existe';
			}
?>