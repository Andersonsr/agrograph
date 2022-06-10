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
let map;
let markers = [];
let contador=1;
function initialize() {
    map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'satellite',
		center:new google.maps.LatLng(-31.32,-53.99),
		zoom:18, 
    };
                    
    // Display a map on the page
    map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
    map.setTilt(45);
        

                        


	google.maps.event.addListener(map, 'click', function(event) {
		
		$("#pontos").append("<div class='form-group' id='ponto"+contador+"'><label>Ponto "+contador+"</label><br /><label>Latitude:&nbsp;</label><input type='text' name='lat"+contador+"' value='"+event.latLng.lat()+
		"'/><label>&nbsp;&nbsp;Longitude:&nbsp;</label><input type='text'  name='lng"+contador+"' value='"+event.latLng.lng()+"'/></div>");

		$("#contador").val(contador);
		
		//add form final
		$("#superForm").append("<div id='form"+contador+"'><input type='hidden' name='lat"+contador+"' id='lat"+contador+"' value='"+event.latLng.lat()+
		"'/><input type='hidden'  name='lng"+contador+"' id='lng"+contador+"' value='"+event.latLng.lng()+"'/></div>");
		
		
		if(contador == 1){
			$("#btnRemoverPontos").slideDown();
			$("#botao").show();
		}
		contador++;
		
		placeMarker(event.latLng, map);
	});
}
	function placeMarker(position) {
		const marker = new google.maps.Marker({
		  position: position,
		  map: map
		});  
		markers.push(marker);
	}
	 // Sets the map on all markers in the array.
	function setMapOnAll(map) {
	  for (let i = 0; i < markers.length; i++) {
		markers[i].setMap(map);
	  }
	
	}
 // Removes the markers from the map, but keeps them in the array.
	function clearMarkers() {
	  setMapOnAll(null);
	}
	// Deletes all markers in the array by removing references to them.
	function deleteMarkers() {
	  clearMarkers();
	  removePontos();
	  markers = [];
	}
	function removePontos(){
		var elem, element, form;
		for(var i=1; i<contador; i++){
			elem = "ponto"+i;
			form = "form"+i;
			element = document.getElementById(elem);
			element.parentNode.removeChild(element);
			element = document.getElementById(form);
			element.parentNode.removeChild(element);
			
		}
		contador=1;
		$("#btnRemoverPontos").slideUp();
		$("#botao").hide();
	}

$(document).ready(function(){
$("#formPontos").submit(function(){
	event.preventDefault();
	var cont = $("#contador").val();
	
	var lat = [];
	var lng = [];
	for(var i=1; i<= cont; i++){
			
			lat.push($("input[name='lat"+i+"']").val());
			lng.push($("input[name='lng"+i+"']").val());
		}
	$.post("recebePontos.php", {
		latitude : lat, longitude : lng, vcontador : cont
	}, function(msg){
		$("#cardVariaveis").show();
		$("#resultado1").html(msg);
	});
	return false;
});



$("#formVariaveis").submit(function(){
	event.preventDefault();
	var cont = $("#contador").val();
	var variavel = $("#variavel").val();
	var lat = [];
	var lng = [];
	//add form final
		$("#superForm").append("<input type='hidden' name='variavel' value='"+variavel+"'/>");

	
	for(var i=1; i<= cont; i++){
			
			lat.push($("input[name='lat"+i+"']").val());
			lng.push($("input[name='lng"+i+"']").val());
		}
	$.post("recebeVariaveis.php", {
		
		
		latitude : lat, longitude : lng, vcontador : cont, vvariavel: variavel
	}, function(msg){
		$("#cardData").show();
		$("#resultado2").html(msg);
	});
	return false;
});


});

</script>
	<style>*{font-family: 'Roboto', sans-serif;}.sidebar .nav li .nav-link p {font-weight:600}</style>

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
                                    <h4 class='card-title'>Selecione os pontos para delimitação do polígono:</h4>
                                </div>
                                <div class="card-body">
									<div class="row" id="btnRemoverPontos" style="display:none">
										<div class="col-md-10 pr-1">
											<button onclick="deleteMarkers();" class="btn btn-info btn-sm">Refazer perímetro</button>
											<br />
											<br />
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
										<div class="col-md-10 pr-1">
										<form action="/" method="post" id="formPontos">
											<div id="pontos">
										
											</div>
											<input type="hidden" id="contador"/>
											<div class='row'>
												<div class="col-md-1 pr-1">
													<button type="submit" class="btn btn-info btn-fill" style="display:none" id="botao">Enviar</button>
												</div>
											</div>

										</form>
										</div>
										
									</div>
									<div class="clearfix"></div>
                                </div>
								

                            </div>
                        </div>
                    </div>
					<div class="row" id="cardVariaveis" style="display:none">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class='card-title'>Variável:</h4>
																				
								</div>
								<div class="card-body">
									<form action="/" method="post" id="formVariaveis">										
										<div id='resultado1'>
										</div>
									</form>
								</div>
							</div>
						</div>
					
					</div>
					<div class="row" id="cardData" style="display:none">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class='card-title'>Data:</h4>
								</div>
								<div class="card-body">
									<form action="consultaBanco.php" method="post" id="formData">										
										<div id="superForm"></div>
										<div id='resultado2'>
										</div>
										
									</form>
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
