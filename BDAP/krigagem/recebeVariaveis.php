<?php
include_once '../sessioncheck.php';
include_once '../connect.php';

?>


<div class="row">
	<div class="col-md-10 pr-1" >
										

	<label>Data:</label>
	
	<select name='data' class="custom-select" id="data">
	
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
				 " OPTIONAL match (d:Data)<-[q:Quando]-(m:Medicao)-[o:Onde]->(node) WITH m, d MATCH (u:User)<-[p:Proprietario]-(m)-[oq:Oque]->(v:Variavel)".
				 " WHERE  u.email = '$email' AND v.tipo='". $_POST['vvariavel']."'".
				 " RETURN DISTINCT d.data".
				 " ORDER BY d.data";
		
		// echo "<p>$query</p>";
		$result = $client->run($query);
																
		foreach($result as $r){
			
			$t = $r->get('d.data');
			
			$data = explode("-", $t);
			$datanova =$data[2].'/'.$data[1].'/'.$data[0];
			echo '<option value="'.$t.'">'.$datanova.'</option>';
			
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
