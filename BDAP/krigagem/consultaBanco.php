<?php
//echo "<pre>";
//print_r($_POST);
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
<?php
    include_once '../sessioncheck.php';
	include_once '../connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

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
	<style>*{font-family: 'Roboto', sans-serif;}.sidebar .nav li .nav-link p {font-weight:600}</style>
	<style>
	#map_wrapper {
		height: 400px;
	}

	#map_canvas {
		width: 100%;
		height: 100%;
	}
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
		center:new google.maps.LatLng(-31.32,-53.99),
		zoom:18, 
    };
 map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
		$("#map_wrapper").hide();

}

$(document).ready(function(){

	$('input[type=radio][name=isotropia]').change(function() {
		if (this.value == 'isotropia') {
			$("#anisotropia").slideUp();
		}
		else {
			$("#anisotropia").slideDown();

		}
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
                    <li>
                        <a class="nav-link" href="../consultas/consultas.php">
                            <i class="nc-icon nc-cloud-download-93"></i>
                            <p>Consultas</p>
                        </a>
                    </li>
                    <li class="nav-item active">
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
                    <a class="navbar-brand" href="#">Krigagem</a>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class='card-title'>Ajuste de parâmetros da Krigagem:</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
										<div class="col-md-10 pr-1">
										
										<?php
										$email = $_SESSION['email'];
										$cont = count($_POST)/2-1;
										
										$poli = '';
										if(isset($_POST['lat1'])){
											$poli = "'POLYGON ((";
											for($i=1; $i<=$cont;$i++){
												$la = "lat".$i;
												$lo = "lng".$i;
												$poli .= $_POST[$lo] .' '. $_POST[$la] .', ';
											}
											$poli .= $_POST['lng1'] .' '. $_POST['lat1'] . "))'";
										}
										

										$query = "CALL spatial.intersects('layer', ".$poli." ) YiELD node".
												" OPTIONAL match  (d:Data)<-[q:Quando]-(m:Medicao)-[o:Onde]->(node)".
                                                " WHERE d.data='".$_POST['data']."' WITH m, node MATCH". 
                                                " (u:User)<-[p:Proprietario]-(m)-[oq:Oque]->(v:Variavel) WHERE u.email = '$email'".
                                                " AND v.tipo='".$_POST['variavel']."' RETURN node.latitude, node.longitude, v.valor";
                                              
										
										$result = $client->run($query);
										
										//percorre resultado e monta 3 strings: y <- latitude; x <- longitude e v <- valor
										$x = '';
										$y = '';
										$v = '';
										
										foreach($result as $r){
											$latbd = $r->get('node.latitude');
											$longbd = $r->get('node.longitude');
											$valor = $r->get('v.valor');
											
											$y .= $latbd.',';
											$x .= $longbd.',';
											$v .= $valor.',';
										
										}
										
										$x = substr($x,0,-1);
										$y = substr($y,0,-1);
										$v = substr($v,0,-1);
										
										$_SESSION['x']=$x;
										$_SESSION['y']=$y;
										$_SESSION['v']=$v;
										

										//echo ($x.$y.$v);		
																				
										//chama criação do plot no R
																								
										exec('C:\\"Program Files"\\R\\R-3.6.1\\bin\\Rscript.exe C:\\xampp\\htdocs\\bdap2\\BDAP\\krigagem\\plot.r'.' '.$x.' '.$y.' '.$v);

										  // return image tag

										  //$nocache = rand();

										  echo("<img src='valores_observados.png'/> ");  
										
										?>										
										
										
														
										
										
										
										
											
										</div>										
									</div>
									<form action="apresentaResultado.php" method="post">
										<div class="row">
											<div class="col-md-10 pr-1" >
												<label>Isotropia</label><br />
												<input type="radio" name="isotropia" value="isotropia" checked /><label>&nbsp;Isotropia</label>
												<br />
												<input type="radio" name="isotropia" value="anisotropia" /><label>&nbsp;Anisotropia</label>
												<br />
												<br />
												<div id="anisotropia" style="display:none;">
													<label>Nº de direções</label>
													<input type="text" name="direcoes" class="form-control" style="width:180px;"/>
													<label>Ângulo</label>
													<input type="text" name="angulo" class="form-control" style="width:180px;"/>
													<br />
												</div>
												<label>Número de atrasos</label>
												<input type="text" name="nlag" class="form-control" value = '10' style="width:180px;"/>
												<label>Tamanho da matriz</label>
												<input type="text" name="matriz" class="form-control" value = '50' style="width:180px;"/>
											</div>
										</div>											
										<div class='row'>
											<div class="col-md-1 pr-1">
												<button type="submit" class="btn btn-info btn-fill">Enviar</button>
											</div>
										</div>
									</form>
									<div class="clearfix"></div>
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
<div id="map_wrapper">
	<div id="map_canvas" class="mapping"></div>
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
