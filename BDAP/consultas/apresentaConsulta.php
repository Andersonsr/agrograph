<?php
include_once '../sessioncheck.php';
include_once '../connect.php';
// print_r($_POST);
// print_r($_SESSION);
?>

<!--
=========================================================
 Light Bootstrap Dashboard - v2.0.1
=========================================================

 Product Page: https://www.creative-tim.com/product/light-bootstrap-dashboard
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/light-bootstrap-dashboard/blob/master/LICENSE)

 Coded by Creative Tim
=========================================================

 The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.  -->


<!DOCTYPE html>
<html lang="en">
<head>
<script>
var markers = [];
</script>

<?php

// print_r($_POST);
// print_r($_SESSION);
$email = $_SESSION["email"];
$data = [];
$variables = [];

$funcdict = array(
	'>' => function($value1, $value2){return $value1 > $value2;},
	'<' => function($value1, $value2){return $value1 < $value2;},
	'=' => function($value1, $value2){return $value1 == $value2;},
	'>=' => function($value1, $value2){return $value1 >= $value2;},
	'<=' => function($value1, $value2){return $value1 <= $value2;}
);

if(isset($_POST['variaveis'])){
	foreach($_SESSION['data'] as $e){
		// echo('oi');
		$ok = true;
		for($i=0; $i<count($_POST['variaveis']); $i++){
			if($e->variable == $_POST['variaveis'][$i]){
				if($funcdict[$_POST['operadores'][$i]]($e->value, $_POST['valores'][$i])){
					continue;
				}
				$ok = false;
				break;
			}		
		}
		if($ok){
			array_push($data, $e);
		}
	}
}
else {
	$data = $_SESSION['data'];
}

$dict = array();
for($i = 0; $i < count($data); $i++){
	if(!in_array($data[$i]->variable, $variables)){
		array_push($variables, $data[$i]->variable);
	}
	// se o ponto ja existe adiciona o conteudo ao conteudo existente se nao cria um novo ponto 
	$conteudo = $data[$i]->variable . ': '. $data[$i]->value .' ('. $data[$i]->date . ")<br>";
	$key = $data[$i]->latitude." ".$data[$i]->longitude;

    if (array_key_exists($key,  $dict)){
		$dict[$key]['conteudo'] .= $conteudo; 
	}
	else{
		$newObj = array(
			'latitude' => $data[$i]->latitude,
			'longitude' => $data[$i]->longitude,
			'conteudo' => $conteudo, 	
		);
		$dict += [$key => $newObj];
	}
}
$i = 0;
foreach($dict as $d){
	echo "
	<script>
	// Multiple Markers
    markers.push([
        'Ponto$i', ".$d['latitude'].", ".$d['longitude'].", '" .$d['conteudo']."']);</script>";
	$i++;
}

?>


    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../../images/logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Agrograph</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../../assets/css/demo.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!--===============================================================================================-->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<style>*{font-family: 'Roboto', sans-serif;}</style>
	<style>
	#map_wrapper {
		height: 400px;
	}

	#map_canvas {
		width: 100%;
		height: 100%;
	}
	.form-control{width:170px;}
	</style>
	<script>

jQuery(function($) {
    // Asynchronously Load the map API 
    var script = document.createElement('script');
    script.src = "//maps.googleapis.com/maps/api/js?sensor=false&callback=initialize&key=AIzaSyBQ9J6iIfkrIhxltHODZBAyK1Nyir9bS20";
    document.body.appendChild(script);
});

function initialize() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'satellite',
		center:new google.maps.LatLng(markers[0][1],markers[0][2]),
		zoom:10, 
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
        

                        
    // Info Window Content
	var infoWindowContent = [];
	var teste;
	for( i = 0; i < markers.length; i++ ) {
		teste = '<div class="info_content">' +
        '<h3>'+markers[i][0]+'</h3>' +
        '<p>'+markers[i][3]+'</p></div>';
		infoWindowContent.push([teste]);
    } 
    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Loop through our array of markers & place each one on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Allow each marker to have an info window    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }
}

$(document).ready(function(){
	$("#maisFiltros").click(function(){
		let div = document.createElement('div');
		div.innerHTML = 
		`
		<label>+ Filtros:</label>
		<div class="row">
			<div class='form-group mb-6' style="margin-left:8px">
				<select name='variaveis[]' class="custom-select">
					<option value='' selected>Variáveis</option>
						<?php
							foreach($variables as $t){
								echo '<option value="'.$t.'"/>'.$t.'</option>';
							}
						?>
				</select>
				<select name='operadores[]' class="custom-select">
					<option value='' selected>Operadores</option>
					<option value='>'>Maior</option>
					<option value='>='>Maior ou igual</option>
					<option value='<'>Menor</option>
					<option value='<='>Menor ou igual</option>
					<option value='='>Igual</option>
				</select>
			</div>
			<div class='form-group mb-3' style='margin-left:4px'>											
				<input type="text" class="form-control" name="valores[]" placeholder="Valor" aria-label="Valor"/>
			</div>
												
			<div class="clearfix"></div>
		</div>`;
		// console.log('oi');
		// <select name='concatenadores[]' class="custom-select">
		// 	<option value='' selected>Operação</option>
		// 	<option value='AND'>E</option>
		// 	<option value='OR'>OU</option>
		// </select>
		
		document.getElementById('extraOptions').appendChild(div);
	});

});
</script>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-image="../../assets/img/3.png" data-color="darkGreen">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a class="simple-text">
                        <img src="../../images/logo.png">
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a class="nav-link" href="../inicio.php">
                            <i class="nc-icon nc-bank"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="../armazenardados/armazenardados.php">
                            <i class="nc-icon nc-cloud-upload-94"></i>
                            <p>Armazenar Dados</p>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="../consultas/consultas.php">
                            <i class="nc-icon nc-cloud-download-93"></i>
                            <p>Consultas</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="../krigagem/krigagem.php">
                            <i class="nc-icon nc-map-big"></i>
                            <p>Krigagem</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="../user/user.php">
                            <i class="nc-icon nc-badge"></i>
                            <p>Perfil</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="../signoff.php">
                            <i class="nc-icon nc-delivery-fast"></i>
                            <p>Sair</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Consultas</a>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
									<div class="row">
										<div class="col-md-9">
											<h4 class='card-title'>Pontos no perímetro:</h4>
										</div>
										<div class="col-md-2">
											<button class="btn btn-primary btn-fill btn-sm" type="button" data-toggle="collapse" data-target="#filtros" aria-expanded="false" aria-controls="collapseExample">
											Filtros
											</button>
										</div>
									</div>
                                </div>
                                <div class="card-body">
                                    <div id="filtros" class="collapse">
										<form action="apresentaConsulta.php?filtros" method="post">
											<label>Filtros:</label>
											<div class="row">
												<div class='form-group mb-6' style="margin-left:8px">
													<!-- <label>Filtros:</label>
													<br /> -->
													<!--- Listar todas as variaveis -->
													<select name='variaveis[]' class="custom-select">
														<option value='' selected>Variáveis</option>
														<?php
															foreach($variables as $t){
																echo '<option value="'.$t.'"/>'.$t.'</option>';
															}
														?>
													</select>
													<select name='operadores[]' class="custom-select">
														<option value='' selected>Operadores</option>
														<option value='>'>Maior</option>
														<option value='>='>Maior ou igual</option>
														<option value='<'>Menor</option>
														<option value='<='>Menor ou igual</option>
														<option value='='>Igual</option>
													</select>
												</div>
												<div class='form-group mb-3' style='margin-left:4px'>											
													<input type="text" class="form-control" name="valores[]" placeholder="Valor" aria-label="Valor"/>
												</div>
												<div class='form-group mb-3' style='margin-left:4px' id="btnMaisFiltros">											
													<button type="button" class="btn btn-primary btn-fill btn-sm" id="maisFiltros">Mais filtros</button>
												</div>
												<div class="clearfix"></div>
											</div>
											<div id='extraOptions'></div>
											<div class="row">
												<div class="col-md-1 px-1" style="margin-left:4px">
													<button type="submit" class="btn btn-info btn-fill">Aplicar Filtros</button>
													<br />
													<br />
													<br />
												</div>
											</div>
										</form>
									</div>
								</div>
										
								<div class="row">
										<div class="col-md-10 pr-1">
											
											<div id="map_wrapper">

												<div id="map_canvas" class="mapping"></div>
											</div>
											
										</div>

										
									</div>
									<div class="row">
									
										<div class="col-md-10 text-right">
											<br/>
											<form action="relatorio.php" method="post">
												
												<?php
													$json = json_encode($data);
													echo "<input type='hidden' name='data' value='$json'/>";
												?>
												<button type="submit" class="btn btn-secondary btn-fill btn-sm ">Gerar relatório</button>
											</form>
										</div>
									</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav>
                        <p class="copyright text-center">
                            Agrograph
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
    </div>  
</body>
<!--   Core JS Files   -->
<script src="../../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../../assets/js/plugins/bootstrap-switch.js"></script>
<!--  Chartist Plugin  -->
<script src="../../assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="../../assets/js/demo.js"></script>

</html>
