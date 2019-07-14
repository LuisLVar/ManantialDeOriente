<?php
include("config.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 

    $myusername = mysqli_real_escape_string($db, $_POST['inputEmail']);
    $mypassword = mysqli_real_escape_string($db, $_POST['inputPassword']);

    $sql = "SELECT idUsuario FROM usuario WHERE usuario = '$myusername' and password = '$mypassword'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $active = $row['active'];

    $count = mysqli_num_rows($result);

    // If result matched $myusername and $mypassword, table row must be 1 row

    if ($count == 1) {
        //session_register("myusername");
        $_SESSION['login_user'] = $myusername;
        //echo $myusername;
        if ($myusername == "admin") {
            header("location: pedidos.php");
        } else {
            header("location: pedidostr.php");
        }
    } else {
        $message = "Usuario o password incorrecto.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manantial de Oriente</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="cssLogin.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <div class="row no-gutter">
            <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
            <div class="col-md-8 col-lg-6">
                <div class="login d-flex align-items-center py-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h3 class="login-heading mb-4">Bienvenido!Prueba</h3>
                                <form action="" method="post">
                                    <div class="form-label-group">
                                        <input type="text" id="inputEmail" name="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                                        <label for="inputEmail">Usuario</label>
                                    </div>
                                    <div class="form-label-group">
                                        <input type="password" id="inputPassword" name="inputPassword" class="form-control" placeholder="Password" required>
                                        <label for="inputPassword">Contraseña</label>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" name="loginBoton">Ingresar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Funciones JS
    <script src="funciones.js"></script>
    <script>
        function iniciarSesion() {
            var user = document.getElementById("inputEmail").value;
            var pass = document.getElementById("inputPassword").value;

            if (user == "admin" && pass == "pass") {
                <
                ? php ? >
                    window.location.href = "pedidos.php";
            } else if (user == "usuario1" && pass == "manantial") {
                window.location.href = "pedidostr.php";
            } else {
                <
                ? php ? >
                    alert("Usuario incorrecto");
                document.getElementById("inputEmail").value = "";
                document.getElementById("inputPassword").value = "";
            }
        }
    </script>-->


</body>

</html>