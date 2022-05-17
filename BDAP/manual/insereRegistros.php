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
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../../images/logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>AgroGraph</title>
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
   		
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<style>*{font-family: 'Roboto', sans-serif;}</style>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-image="../../assets/img/3.png" data-color="green">
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
                    <li class="nav-item active">
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
                    <a class="navbar-brand" href="#">Armazenar Dados</a>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class='card-title'>Descrição dos registros</h4>
                                </div>
                                <div class="card-body">
                                    <form action="enviarBD.php" method="post" id="formulario">
										<div class="col-md-12 pr-1">
										
										<table class="table">
											<thead>
												<tr>
												<th>Registro</th>
												<th>Latitude</th>
												<th>Longitude</th>
										<?php
                                            $dateIndex = -1;
                                            $timeIndex = -1;
											for ($c=1; $c <= $_POST['variaveis']; $c++) {
                                                if(preg_match("/hora|horario|horário|time/i", $_POST['variavel'.$c]) > 0){
                                                    $timeIndex = $c;
                                                }
                                                if(preg_match("/data|date|dia|day/i", $_POST['variavel'.$c]) > 0){
                                                    $dateIndex = $c;
                                                }
												echo "<th>".$_POST['variavel'.$c]."</th>";
											}
                                            echo "
                                            <input type='hidden' name='indiceData' value='$dateIndex'/>
                                            <input type='hidden' name='indiceTime' value='$timeIndex'/>
                                            "
											?>
											</tr>
												</thead>
												<tbody>
												<?php
                                                    
													for ($l=1; $l <= $_POST['registros']; $l++) {
													
                                                    echo "
													<tr>
														<td>
															".$l."
														</td>
														<td>
															<input class='form-control' type='text' name='l".$l."lat'/>
														</td>
														<td>
															<input type='text' class='form-control' name='l".$l."long'/>
														</td>
														";
															for ($c=1; $c <= $_POST['variaveis']; $c++) {
																echo "
																<td>
																	<input type='text' class='form-control' name='l".$l."var$c' />
																</td>";
															}
											
                                                ?>

													</tr>
													<?php
													}
													
											
										 echo "</tbody>
												</table>
											
                                            

											<input type='hidden' name='registros' value='".$_POST['registros']."'/>
											<input type='hidden' name='variaveis' value='".$_POST['variaveis']."'/>";
											
                                            if($dateIndex == -1){//data fixa
                                                echo "
                                                <div class='form-group'>
                                                    <label>Data:</label>
                                                    <input type='date' name='data' class='form-control'  required>
                                                </div>
                                                    ";
                                            }
                                            else{//data como variavel
                                                echo"
                                                <div class='form-group'>
                                                    <label>Escolha o formato da data presente no arquivo:</label>
                                                    <input type='radio' name='formato' value='dd-mm-yyyy' checked /> <label>dia-mês-ano  </label>
                                                    <input type='radio' name='formato' value='mm-dd-yyyy'/> <label>mês-dia-ano  </label>
                                                    <input type='radio' name='formato' value='mm-dd-yyyy'/> <label>ano-mês-dia  </label>
                                                 </div>
                                                ";
                                            }
											for ($c=1; $c <= $_POST['variaveis']; $c++) {
												echo "
													<input type='hidden' name='var$c' value='".$_POST['variavel'.$c]."' size='4'>
													<input type='hidden' name='medida$c' value='".$_POST['medida'.$c]."' size='4'>
												";
											}
                                            
										?>
                                        <div class="col-md-1 px-1">
                                            <button type="submit" class="btn btn-info btn-fill">Enviar</button>
                                        </div>
                                        <div class="clearfix"></div>
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
                            AgroGraph
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="../../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../../assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!--  Chartist Plugin  -->
<script src="../../assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="../../assets/js/demo.js"></script>

</html>