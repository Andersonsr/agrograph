<?php
include_once '../sessioncheck.php';                                                   
include '../connect.php';
require_once '../../composer/vendor/autoload.php';
// error_reporting(1);
// print_r($_POST);
// print_r($_SESSION);

$filename = $_POST['nomeArquivo'];
$cabecalho = $_POST['cabecalho'];
$email = $_SESSION['email'];
$indiceData = -1;
$indiceHora = -1;
$formato = $_POST['formato'];
$latitude = -1;
$longitude = -1;
$erro = false;

$fileType = ucfirst(explode('.', $filename)[1]);
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileType);

$spreadsheet = $reader->load($filename);
$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, false);

if (!empty($sheetData)) {
	$row = 0;
	$payload = [];	
	foreach($sheetData as $data){
		for ($counter = 0; $counter < count($sheetData[0]); $counter++){
			$arraycategoria[] = $_POST["tipo$counter"];
			$arraycampo[] = $_POST["campo$counter"];
			$arraymedida[] = $_POST["medida$counter"];
			
			if(preg_match("/latitude/i", $_POST["campo$counter"])>0){
				$latitude = $counter;
			}
			else if(preg_match("/longitude/i", $_POST["campo$counter"])>0){
				$longitude = $counter;
			}
			else if(preg_match("/data|date|dia|day|fecha/i", $_POST["campo$counter"])>0){
				$indiceData = $counter;
			}
			else if(preg_match("/hora|horario|horário|time/i", $_POST["campo$counter"])>0){
				$indiceHora = $counter;
			}	
		}
	
		if($indiceData==-1 && empty($_POST['data'])){
			fclose($handle);
			$erro = true;
			header("location:armazenardados.php?faltaData");
		}
		 
		if (!($row == 0 && $cabecalho == 'sim')){
			$dont = array($indiceData, $indiceHora, $latitude, $longitude);						
			for ($i = 0; $i < count($data); $i ++){
				if (!in_array($i, $dont)){
					$measurement = array(
						'longitude' => $data[$longitude],
						'latitude' => $data[$latitude]
					  );
  					if ($indiceHora != -1) $measurement += ['time' => $data[$indiceHora]];
					
					if( $indiceData != -1){
						$measurement += ['date' => $data[$indiceData]];	
					}
					else {
						$measurement += ['date' => $_POST['data']];
					}
					$measurement += ['variable' => $arraycampo[$i]];
					$measurement += ['unit' => $arraymedida[$i]];
					$measurement += ['category' => $arraycategoria[$i]];
					$measurement += ['value' => $data[$i]];
					$payload[] = $measurement;
					
				}
			}
		}
		$row ++;
	}

	unlink($filename);	
	echo json_encode([
		'data' => $payload, 
		'authToken' => $_SESSION['token'], 
		'cross_secret' => $_ENV['CROSS_SERVER_SECRET']
	]);
	
}
?>


			
			