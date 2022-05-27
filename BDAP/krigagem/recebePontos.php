<?php
include_once '../connect.php';
include_once '../sessioncheck.php';
?>


<div class="row">
	<div class="col-md-10 pr-1" >
										

	<label>Variável:</label>
	<select name='variavel' class="custom-select" id="variavel">
	
	<?php
	$email = $_SESSION['email'];
	$poli = '';
	if(isset($_POST['latitude'][0])){
		$poli = "'POLYGON ((";
		for($i=0; $i<$_POST['vcontador'];$i++){
			$la = "latitude".$i;
			$lo = "longitude".$i;
		$poli .= $_POST['longitude'][$i].' '. $_POST['latitude'][$i] .', ';
		}
		$poli .= $_POST['longitude'][0] .' '. $_POST['latitude'][0] . "))'";
	}
	
											
		$query = "CALL spatial.intersects('layer', ".$poli." ) YiELD node". 
				 " OPTIONAL MATCH (v:Variavel)<-[oq:Oque]-(m:Medicao)-[o:Onde]->(node)".
				 " WITH m, v MATCH (m)-[p:Proprietario]->(u:User) WHERE u.email = '$email'".
				 " RETURN DISTINCT v.tipo".
				 " ORDER BY v.tipo;";
		
		// echo "$query";
		$result = $client->run($query);
																
		foreach($result as $r){
			
			$t = $r->get('v.tipo');
			
			echo '<option value="'.$t.'">'.$t.'</option>';
			
			//<input type="checkbox" name="'.$t.'" value="'.$t.'"/> <label>'.$t.'</label> <br />';
		
		}
		
	?>
		
	</select>
	</div>
										

</div>

<div class="row">
<div class="col-md-1 pr-1">
<br />
		<button type="submit" class="btn btn-info btn-fill">Enviar</button>
</div>
</div>
