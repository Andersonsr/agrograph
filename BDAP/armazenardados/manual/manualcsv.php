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
    include_once '../../sessioncheck.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../../../images/logo.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Agrograph</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <!-- CSS Files -->
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../../assets/css/light-bootstrap-dashboard.css?v=2.0.0 " rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../../../assets/css/demo.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!--===============================================================================================-->
    <script>
        $(document).ready(function() {
            $('#formulario').submit(function(e) {
                var datos = $("#formulario").serialize();
                var file = $('input[type="file"]').val();
                var exts = ['csv'];
                // first check if file field has any value
                if (file) {
                    // split file name at dot
                    var get_ext = file.split('.');
                    // reverse name to check extension
                    get_ext = get_ext.reverse();
                    // check file type is valid as given in 'exts' array
                    if ($.inArray(get_ext[0].toLowerCase(), exts) > -1) {
//                        alert('Allowed extension!');
                    } else {
                        alert('Selecione um arquivo CSV');
                        event.preventDefault();
                    }
                }
            });
        });

    </script>
</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-image="../../../assets/img/3.png" data-color="darkGreen">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a class="simple-text">
                        <img src="../../../images/logo.png">
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a class="nav-link" href="../../inicio.php">
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
                        <a class="nav-link" href="../../consultas/consultas.php">
                            <i class="nc-icon nc-cloud-download-93"></i>
                            <p>Consultas</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="../../krigagem/krigagem.php">
                            <i class="nc-icon nc-map-big"></i>
                            <p>Krigagem</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="../../user/user.php">
                            <i class="nc-icon nc-badge"></i>
                            <p>Perfil</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="../../signoff.php">
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
                                    <h4 class='card-title'>Armazenamento manual</h4>
                                </div>
                                <div class="card-body">
                                    <form action="tratarcsv.php" method="post" id="formulario" enctype="multipart/form-data">
                                        <div class="col-md-12 pr-0">
                                            O arquivo CSV deverá ter uma coluna com a Latitude e outra com a Longitude. Os valores deverão estar no formato decimal.<br>
                                            As demais colunas serão nomeadas após a submissão do arquivo.<br>
                                        </div>
                                        <div class="col-md-12 pr-1">
                                            Arquivo:<input type="file" name="arquivo" accept=".csv" required>
                                        </div>
                                        <div class="col-md-5 pr-1">
                                            CSV contém cabeçalho: <input type="radio" name="cabecalho" value="sim" checked> Sim
                                            <input type="radio" name="cabecalho" value="nao" accept=".csv"> Não
                                        </div>
                                        <div class="col-md-5 pr-1">
                                        <!-- <div class='form-group'> -->
                                            Data da coleta: <input type="datetime-local"  name="data" required="true" required>
                                        </div>
                                        
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
                            Agrograph
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="../../../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../../../assets/js/core/popper.min.js" type="text/javascript"></script>
<script src="../../../assets/js/core/bootstrap.min.js" type="text/javascript"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../../../assets/js/plugins/bootstrap-switch.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQ9J6iIfkrIhxltHODZBAyK1Nyir9bS20"></script>
<!--  Chartist Plugin  -->
<script src="../../../assets/js/plugins/chartist.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../../../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../../../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>
<!-- Light Bootstrap Dashboard DEMO methods, don't include it in your project! -->
<script src="../../../assets/js/demo.js"></script>

</html>
