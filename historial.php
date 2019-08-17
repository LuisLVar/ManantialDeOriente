<?php
include('session.php');
if ($_SESSION['login_user'] != "admin") {
    header("Location: logout.php");
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
    <link href="css/matrix-style.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-responsive.min.css" />

    <!-- Custom fonts for this template -->
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Funciones JS-->
    <script src="matrix.tables.js"></script>
    <script src="jquery.dataTables.min.js"></script>
    <script src="funciones.js"></script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="pedidos.php">Pedidos</a>
            <a class="navbar-brand" href="clientes.php">Clientes</a>
            <a class="navbar-brand" href="historial.php">Historial</a>
            <a class="btn btn-primary" href="logout.php" onclick="return confirm('Seguro que quieres abandonar?')">Cerrar Sesión</a>
        </div>
    </nav>

    <!-- Masthead -->
    <header class="call-to-action text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5">Manantial de Oriente</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Historial de Pedidos</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>No. Pedido</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Cliente X</th>
                                <th>No. Garrafones</th>
                                <th>No. Fardos</th>
                                <th>Pago</th>
                                <th>Debe (Q)</th>
                                <th>Debe garrafones</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select P.idPedido, P.fecha, P.fCliente, P.cantidadGarrafon, P.cantidadFardo,
                             P.cancelo, P.debeQ, P.DebeGarrafon, P.Observacion, P.Estado, 
                             C.nombre from pedido P inner join cliente C on P.fCliente = C.idCliente order by P.idPedido";
                            $result = mysqli_query($db, $sql);

                            if ($result) {
                                while ($data = mysqli_fetch_assoc($result)) {
                                    echo '<tr class= "gradeX">
        <td>' . $data["idPedido"] . ' </td>
        <td>' . $data["fecha"] . '</td>
        <td>' . $data["fCliente"] . ' - '. $data["nombre"] .'</td>
        <td>' . $data["clienteX"] .'</td>
        <td class="center">' . $data["cantidadGarrafon"] . '</td>
        <td class="center">' . $data["cantidadFardo"] . '</td>
        <td class="center">' . $data["cancelo"] . '</td>
        <td class="center">' . $data["debeQ"] . '</td>
        <td class="center">' . $data["DebeGarrafon"] . '</td>
        <td>' . $data["Observacion"] . '</td>
        <td class="center">' . $data["Estado"] . '</td>
    </tr>';
                                }
                            } else {
                                echo "Error al cargar cliente.";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="call-to-action text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h2 class="mb-4">Tu futuro es creado por lo que haces hoy, no mañana.</h2>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item">
                            <a href="#">Regresar al inicio</a>
                        </li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">&copy; Manantial de Oriente 2019. Todos los derechos reservados</p>
                </div>
                <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fab fa-facebook fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fab fa-twitter-square fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-instagram fa-2x fa-fw"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>