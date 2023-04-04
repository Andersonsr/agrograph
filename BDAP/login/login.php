<!DOCTYPE html>
<html lang="en">

<head>
    <title>Agrograph</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../../images/logo.png">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/util.css">
    <link rel="stylesheet" type="text/css" href="../../css/main.css">
    <!--===============================================================================================-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <!--===============================================================================================-->
    <script>
        $(document).ready(function() {
            $('#formulario').submit(function(e) {
                var datos = $("#formulario").serialize();
                $.ajax({
                    type: "POST",
                    url: 'http://localhost:8000/v1/login/',
                    data: datos,
                    dataType: 'json',
                    success: function(r) {
                        // console.log(1);
                        $.ajax({
                        type: "POST",
                        url: 'initSession.php',
                        data: datos,
                        dataType: 'json',
                        success: function(data) {
                            window.location.href = "../inicio.php";
                        },
                        error: function(data){
                           alert(data.responseJSON.message);
                    }
                        
                    });
                        
                    },
                    error: function(data){
                        alert(data.responseJSON.message);
                    }
                });
                return false;
            });
        });



    </script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }

    </style>
</head>

<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('../../images/3.png');">
            <div class="wrap-login100">
                <form class="login100-form validate-form" action="" method="post" id="formulario">
                    <span class="login100-form-logo">
                        <i class="zmdi zmdi-account"></i>
                    </span>

                    <span class="login100-form-title p-b-34 p-t-27">
                        Fazer Login
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Digite um email">
                        <input class="input100" type="email" name="email" placeholder="Email">
                        <span class="focus-input100" data-placeholder="&#xf15a;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Digite uma senha">
                        <input class="input100" type="password" name="password" minlenght="8" maxlength="16" placeholder="Senha">
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn boton">
                            Login
                        </button>
                    </div>
                    <div class="text-center p-t-90">
                        <a class="txt1" href="signin.php">
                            Cadastre-se
                        </a><br>
                        <a class="txt1" href="../index.php">
                            Inicio
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>
    <!--===============================================================================================-->
    <script src="../../vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="../../vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="../../vendor/bootstrap/js/popper.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../../vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="../../vendor/daterangepicker/moment.min.js"></script>
    <script src="../../vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="../../vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="../../js/main.js"></script>
    <!--===============================================================================================-->
    <script src="https://kit.fontawesome.com/54c96067f2.js" crossorigin="anonymous"></script>

</body>

</html>
