<?php
include_once '../sessioncheck.php';                                                   
include '../connect.php';
require_once '../../composer/vendor/autoload.php';
error_reporting(1);
print_r($_POST);
print_r($_SESSION);

$expressaoDataBR = "/(([^0-9][1-9][^0-9])|(0[1-9])|([1-2][0-9])|(3[0-1]))[-\/](([1-9])|(1[0-2]))[-\/](([0-9]{4})|([0-9]{2}))/";
$expressaoDataUS = "/((0[1-9])|(1[0-2])|^[1-9])[-\/](([^0-9][1-9][^0-9])|(0[1-9])|([1-2][0-9])|(3[0-1]))[-\/](([0-9]{4})|([0-9]{2}))/";
$expressaoAnoAntes = "/((19[7-9][0-9])|(20[0-6][0-9])[-\/](([1-9][^0-9])|(1[0-2]))[-\/](([1-9]$)|([1-2][0-9])|(3[0-1])|(0[1-9])))/";
$filename = $_POST['nomeArquivo'];
$date = $_POST['data'];
$userID = $_SESSION['id'];
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
	
	if(!empty($date)){
		//data fixa para todo o arquivo executa uma vez
		//verifica se ja existe no para a data atual
		$query = "MATCH (d:Data) WHERE d.data = '$date' RETURN d";
		$result = $client->run($query);		
		
		if (!count($result)){
			// echo "criou data";
			$query="CREATE (d:Data {data: '$date'}) RETURN d";
			$result = $client->run($query);
			
		}	
				
	}
	
	$row = 1;
	foreach ($sheetData as $data) { //percorre arquivo csv linha a linha
		$num = count($data);
		if($row == 1){
			//executa uma vez
			for ($counter = 0; $counter < $num; $counter++){
				$arraycategoria[] = $_POST["tipo$counter"];
				$arraycampo[] = $_POST["campo$counter"];
				$arraymedida[] = $_POST["medida$counter"];
				
			
				if(preg_match("/latitude/i", $_POST[$campo])>0){
					$latitude = $counter;
				}
				else if(preg_match("/longitude/i", $_POST[$campo])>0){
					$longitude = $counter;
				}
				else if(preg_match("/data|date|dia|day/i", $_POST[$campo])>0){
					$indiceData = $counter;
				}
				else if(preg_match("/hora|horario|horário|time/i", $_POST[$campo])>0){
					$indiceHora = $counter;
				}
				
			}
			if($indiceData==-1 && empty($_POST['data'])){
				fclose($handle);
				$erro = true;
				header("location:armazenardados.php?faltaData");
			}
		}
		
		if(!($cabecalho == "sim" and $row == 1)){
			// executa n vezes;
			$latitudebd = $data[$latitude];
			$longitudebd = $data[$longitude];
			if(is_numeric($longitudebd) && is_numeric($latitudebd)){
				//verifica se ja existe a localizacao no db
				$query = "MATCH (l:Localizacao) WHERE l.latitude = $latitudebd AND l.longitude = $longitudebd RETURN l";
				$result = $client->run($query);		
				
				//se nao existe insere a localizacao no db
				if (!count($result)){
					$query = "CREATE (l:Localizacao {latitude:$latitudebd, longitude:$longitudebd})"
							." WITH l CALL spatial.addNode('layer',l) YIELD node RETURN node";
		
					$result = $client->run($query);
					
				}
				
				for ($c=0; $c < $num; $c++) { 
					if($c != $longitude && $c != $latitude && $c != $indiceData && $c != $indiceHora){
						$tipo= $arraycampo[$c]; 
						$valor= str_replace(',' , '.' , $data[$c]);
						$medida= $arraymedida[$c];
						$categoria = $arraycategoria[$c];
						
					
						//verifica se ja existe a variavel no banco de dados 
						$query = "MATCH (v:Variavel) WHERE v.tipo = '$tipo' AND v.valor = $valor "; 
						if($arraymedida[$c] != ""){
							$query .= "AND v.unidadeMedida = '$medidabd' ";
						}
						$query .= "RETURN v";
						$result = $client->run($query);
						
						//se nao existe insere no db
						if (!count($result)){
							$query = "CREATE (v:Variavel {tipo: '$tipo', valor: $valor, categoria: '$categoria' ";
							if($arraymedida[$c] != ""){
								$query .=",unidadeMedida: '$medida'"; 
							}
							$query .= "})RETURN v";
							$result = $client->run($query);
							
						}
							
						if($indiceData != -1){
							//data variavel 
							$year;
							$date = $data[$indiceData];
							$date = str_replace("/","-",$date);
							$parts = explode('-', $date);
							
							if($formato == "dd-mm-yyyy"){
								if(preg_match($expressaoDataBR, $date)>0){
									if($parts[2]<100){
										if($parts[2] > 70){
											$year = "19".$parts[2];
										}
										else{
											$year = "20".$parts[2];
										}
									}
									$date ="$year-$parts[1]-$parts[0]";
								}
								else{//nao esta no formato indicado
									fclose($handle); 
									$erro = true;
									header("location:armazenardados.php?formatoErro");
									break;
								}
								
							}
							else if($formato == "mm-dd-yyyy"){
								if(preg_match($expressaoDataUS, $date)>0){
									if($parts[2]<100){
										if($parts[2] > 70){
											$year = "19".$parts[2];
										}
										else{
											$year = "20".$parts[2];
										}
									}
									$date = "$year-$parts[0]-$parts[1]";
								}
								else{//nao esta no formato indicado
									fclose($handle);
									$erro = true; 
									header("location:armazenardados.php?formatoErro");
									break;
								}
							}
							else if($formato == "yyyy-mm-dd"){
								if(preg_match($expressaoAnoAntes, $date)>0){
									if($parts[0]<100){
										if($parts[0] > 70){
											$year = "19".$parts[0];
										}
										else{
											$year = "20".$parts[0];
										}
									}
									$date = "$year-$parts[1]-$parts[2]";
								}
								else{//nao esta no formato indicado
									fclose($handle); 
									$erro = true;
									header("location:armazenardados.php?formatoErro");
									break;
								}
							}
															
							$query = "MATCH (d:Data) WHERE d.data = '$date' RETURN id(d)";
							$result = $client->run($query);			
							//cria no para a data caso nao exista
							if (!count($result)){
								$query="CREATE (d:Data {data: '$date'}) RETURN d";
								$result = $client->run($query);
								// echo "criou data";
							}	
						}

						//para identificar o hyperedge
						$medicaoResumo =" $latitudebd$longitudebd$date";
						if($indiceHora != -1){
							$medicaoResumo.="$data[$indiceHora]";
						} 
						$medicaoResumo .= "$userID";
						$medicaoID = hash("sha256",$medicaoResumo);

						//verifica se ja esxiste o hyperedge para localizacao, data/hora, usuario
						$query = "MATCH (m:Medicao) WHERE m.resumo='$medicaoID' RETURN m";
						$result = $client->run($query);
						
						//cria hyperedge e adiciona a variavel
						if (!count($result)){
							$query =  "MATCH (l:Localizacao) WHERE l.latitude = $latitudebd AND l.longitude = $longitudebd"
							." WITH l MATCH (d:Data) WHERE d.data = '$date' CREATE (l)<-[o:Onde]-(m:Medicao {resumo:'$medicaoID'})-[q:Quando";
							if($indiceHora != - 1){
								$query .= "{horario:'$data[$indiceHora]'}";
							}
							$query .= "]->(d) WITH m MATCH (u:User) WHERE u.email = '$email' CREATE "
							."(m)-[p:Proprietario]->(u) WITH m MATCH (v:Variavel) WHERE v.tipo = '$tipo' "
							."AND v.valor = $valor CREATE (m)-[oq:Oque]->(v)";
							
							$client->run($query);
						}
						else{//adiciona variavel a hyperedge existente
							//verifica se ja existe a conexao entre medicao e a variavel
							//evitando duplicatas
							$query = "MATCH (m:Medicao)-[oq:Oque]->(v:Variavel) WHERE m.resumo='$medicaoID'".
							" AND v.tipo='$tipo' AND v.valor=$valor RETURN m";
							$result= $client->run($query);
							
							if(!count($result)){
								$query = "MATCH (m) WHERE m.resumo='$medicaoID'"
								." WITH m MATCH (v:Variavel) WHERE v.tipo = '$tipo' AND v.valor = $valor";
								if($medidabd!=""){
									$query.=" AND v.unidadeMedida='$medidabd'";
								}
								$query.=" CREATE (m)-[oq:Oque]->(v)";	
								$client->run($query);
							}
							
						}
					}
				}
		
			}
			
		}
		
		$row++;
	}
	
	unlink($filename);	
	if(!$erro){
	header("location:armazenardados.php?insert");
	}
		
}
?>


			
			