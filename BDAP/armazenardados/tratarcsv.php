<?php
    include_once '../sessioncheck.php';
    require_once '../../composer/vendor/autoload.php';
                                            
    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // print_r($_SESSION);
    // $hash = password_hash("12345678", PASSWORD_BCRYPT);
    // if(password_verify("12345678", $hash) ){
    //     echo "1";
    // }
    // echo "</pre>";
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
    <script>
        
        $(document).ready(function() {
            $('#formulario').submit(function(e) {
                var datos = $("#formulario").serialize();
                $('#submit').hide();
                $('#loading').show();
                $.ajax({
                        type: "POST",
                        url: './enviarBD.php',
                        data: datos,
                        success: function(response) {  
                            jsonResponse = JSON.parse(response);
                            console.log(jsonResponse);
                            data = jsonResponse.data;
                            authToken = jsonResponse.authToken;
                            secret = jsonResponse.cross_secret;

                            $.ajax({
                                type: "POST",
                                url: 'http://localhost:8000/v1/insert/',
                                data: {
                                    'data': JSON.stringify(data), 
                                    'authToken': authToken, 
                                    'cross_secret': secret
                                },
                                dataType: 'json',

                                success: function(response) {
                                    window.location.href = "../inicio.php";
                                    alert(response.message);
                                },
                                
                                error: function(response){
                                    $('#loading').hide();
                                    $('#submit').show();
                                    alert(response.message);
                                }
                            });
                        },
                        error: function(response){
                            $('#loading').hide();
                            $('#submit').show();
                            alert('erro');
                        }
                });
                return false;
            });
        });
    </script>
    
    


	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
	<style>*{font-family: 'Roboto', sans-serif;}</style>
	
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
                                    <h4 class='card-title'>Armazenamento de arquivo CSV</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 pr-1">
                                            <form action="" onsubmit="" method="" id="formulario" enctype="multipart/form-data">
                                                <?php
                                            // use PhpOffice\PhpSpreadsheet\IOFactory;
                                            $cabeca = false;
                                            if($_POST['cabecalho'] == 'sim'){
                                                $cabeca = true;
                                            }
                                            
                                            $parts = explode('.', $_FILES['arquivo']['name']);
                                            $fileName = hash('sha256', $_FILES['arquivo']['name']).'.'.$parts[1];
                                            $fileType = ucfirst($parts[1]);
                                            // print_r($_FILES);
                                            // echo $fileName;

                                            if(!move_uploaded_file($_FILES['arquivo']['tmp_name'], $fileName))
                                                echo "Erro ao submeter arquivo CSV. Por favor tente novamente.";

                                            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileType);
                                            $spreadsheet = $reader->load($fileName);
                                            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
                                            // print_r($sheetData);
                                        
                                            if(!empty($sheetData)) {
                                                $cabecalho = $sheetData[1];
                                                $indiceData = -1;
                                                $indiceHora = -1;
                                                $indiceLatitude = -1;
                                                $indiceLongitude = -1;
                                                $c = 0;
                                                echo "<p class='card-title'>Por favor, confirme os tipos de dados das colunas:</p>";
                                                
                                                foreach($cabecalho as $data) {
                                                    echo "
                                                    <div class='row'>

                                                        <div class='col-md-3 pr-1'>
                                                            <div class='form-group'>
                                                                <label>Coluna " . ($c+1) . ":</label> 
                                                                <input type='text' name='campo$c' value='"; 
                                                                if($cabeca){
                                                                    echo($data);
                                                                }  
                                                                echo("' class='form-control' required='true' required />
                                                            </div>
                                                        </div>");
                                                        
                                                    echo(
                                                        "
                                                        <div class='col-md-3 pr-1'>
                                                            <div class='form-group'>
                                                                <label>Unidade de medida:</label>
                                                                <input type='text' name='medida$c' class='form-control'/>                                                               
                                                            </div>
                                                        </div>
                                                        <div class='col-md-3 pr-1'>
                                                            <div class='form-group'>
                                                                <label>Tipo de dado:</label>
                                                                <select name='tipo$c' class='form-control'/>
                                                                    <option>solo</option>
                                                                    <option>produção vegetal</option>
                                                                    <option>produção animal</option>
                                                                    <option>meteorologia</option>
                                                                </select>                                                               
                                                            </div>
                                                        </div>
                                                    </div>");
                                                    $c ++;
                                                }                                                    

                                                if($indiceData == -1){
                                                    echo "
                                                    <div class='form-group'>
                                                        <div class='col-md-3'>
                                                            <div class='row'>
                                                                <label>Data da coleta:</label>
                                                                <input type='date' class='form-control' name='data' required='true' required />
                                                            </div>
                                                            
                                                        </div>
                                                    </div>";
                                                }
                                                else{
                                                    echo "
                                                    <div class='form-group'>
                                                    <label>Escolha o formato da data presente no arquivo:</label>
                                                    <input type='radio' name='formato' value='dd-mm-yyyy' checked /> <label>dia-mês-ano  </label>
                                                    <input type='radio' name='formato' value='mm-dd-yyyy'/> <label>mês-dia-ano  </label>
                                                    <input type='radio' name='formato' value='yyyy-mm-dd'/> <label>ano-mês-dia  </label>
                                                    </div>
                                                    ";
                                                }
                                                    
                                                echo "
                                                <input type='hidden' name='nomeArquivo' value='".$fileName."'>
                                                <input type='hidden' name='cabecalho' value='".$_POST['cabecalho']."'>
                                                <input type='submit' class='btn btn-info btn-fill' id='submit'>
                                                <img src='../../assets/img/loading.gif' width='80px;' id='loading' style='display:none;'>

                                                ";
                                            }
                                            ?>
                                            </form>
                                        </div>
                                        <div class="clearfix"></div>
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
<script src="../../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../../assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ9J6iIfkrIhxltHODZBAyK1Nyir9bS20"></script>
<!--  Chartist Plugin  -->
<script src="../../assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="../../assets/js/demo.js"></script>

</html>

