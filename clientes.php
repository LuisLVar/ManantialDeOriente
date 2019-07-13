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

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
   
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
        <button href="javascript:void(0)" data-toggle="modal" data-target="#nuevo-cliente" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
            <i class="ti-plus"></i> Agregar Nuevo Cliente
        </button>
        <button href="javascript:void(0)" data-toggle="modal" data-target="#rest-deuda" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
            <i class="ti-plus"></i> Pago de deuda
        </button>
        <button href="javascript:void(0)" data-toggle="modal" data-target="#rest-garrafon" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
            <i class="ti-plus"></i> Devolución garrafones
        </button>

        <?php
        if (isset($_POST['submitCliente'])) {
            $nameCliente = mysqli_real_escape_string($db, $_POST['nombreCliente']);
            $dirCliente = mysqli_real_escape_string($db, $_POST['direccionCliente']);
            $telClient = mysqli_real_escape_string($db, $_POST['telCliente']);
            $refClient = mysqli_real_escape_string($db, $_POST['refCliente']);

            //$sql = "SELECT idUsuario FROM usuario WHERE usuario = '$myusername' and password = '$mypassword'";
            $sql = "insert into cliente values(0, '$nameCliente', '$dirCliente', '$telClient', '$refClient', 0, 0);";
            $result = mysqli_query($db, $sql);
            if ($result) {
                $message = "";
                echo "<br><br><hr><p><b><span style=\"color:#64C50E\"> Cliente ingresado exitosamente. </span></b></p><hr>";
            } else {
                echo "<br><br><hr><p><b><span style=\"color:red\"> Error al ingresar cliente. </span></b></p><hr>";
            }
        }
        ?>
        <?php
        if (isset($_POST['submitDinero'])) {
            $nameCliente = mysqli_real_escape_string($db, $_POST['clienteDinero']);
            $pagoCliente = mysqli_real_escape_string($db, $_POST['pagoDinero']);
            //echo "<br><br><hr><p><b><span style=\"color:#64C50E\"> Entro1 </span></b></p><hr>";
            $sql = "SELECT Debe_dinero FROM cliente WHERE idCliente = '$nameCliente'";
            //$sql = "insert into cliente values(0, '$nameCliente', '$dirCliente', '$telClient', '$refClient', 0, 0);";
            $result = mysqli_query($db, $sql);
            $data = mysqli_fetch_assoc($result);
            if ($result && is_numeric($pagoCliente)) {
                $deuda = $data["Debe_dinero"] - $pagoCliente;
                if ($deuda < 0) {
                    echo "<br><br><hr><p><b><span style=\"color:red\"> Error en el pago de deuda, deuda negativa. </span></b></p><hr>";
                } else {
                    $sql = "UPDATE cliente SET Debe_dinero = '$deuda' where idCliente = '$nameCliente'";
                    //$sql = "insert into cliente values(0, '$nameCliente', '$dirCliente', '$telClient', '$refClient', 0, 0);";
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        echo "<br><br><hr><p><b><span style=\"color:#64C50E\"> Pago de deuda exitoso. </span></b></p><hr>";
                    } else {
                        echo "<br><br><hr><p><b><span style=\"color:red\"> Error en el pago de deuda, validar datos. </span></b></p><hr>";
                    }
                }
            } else {
                echo "<br><br><hr><p><b><span style=\"color:red\"> Error en el pago de deuda, validar datos. </span></b></p><hr>";
            }
        }
        ?>
        <?php
        if (isset($_POST['submitGarrafon'])) {
            $nameCliente = mysqli_real_escape_string($db, $_POST['clienteGarrafon']);
            $noGarrafones = mysqli_real_escape_string($db, $_POST['devolGarrafon']);



            //echo "<br><br><hr><p><b><span style=\"color:#64C50E\"> Entro1 </span></b></p><hr>";
            $sql = "SELECT Debe_garrafon FROM cliente WHERE idCliente = '$nameCliente'";
            //$sql = "insert into cliente values(0, '$nameCliente', '$dirCliente', '$telClient', '$refClient', 0, 0);";
            $result = mysqli_query($db, $sql);
            $data = mysqli_fetch_assoc($result);
            if ($result && is_numeric($noGarrafones)) {
                $deuda = $data["Debe_garrafon"] - $noGarrafones;
                if ($deuda < 0) {
                    echo "<br><br><hr><p><b><span style=\"color:red\"> Error en la devolucion de garrafon, validar datos. </span></b></p><hr>";
                } else {
                    $sql = "UPDATE cliente SET Debe_garrafon = '$deuda' where idCliente = '$nameCliente'";
                    //$sql = "insert into cliente values(0, '$nameCliente', '$dirCliente', '$telClient', '$refClient', 0, 0);";
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        echo "<br><br><hr><p><b><span style=\"color:#64C50E\"> Devolucion de garrafon exitosa. </span></b></p><hr>";
                    } else {
                        echo "<br><br><hr><p><b><span style=\"color:red\"> Error en la devolucion de garrafon, validar datos. </span></b></p><hr>";
                    }
                }
            } else {
                echo "<br><br><hr><p><b><span style=\"color:red\"> Error en la devolucion de garrafon, validar datos. </span></b></p><hr>";
            }
        }
        ?>
        <div class="container">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Clientes</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Telefono</th>
                                <th>Dirección</th>
                                <th>Referencia</th>
                                <th>Debe Dinero</th>
                                <th>Debe garrafones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $sql = "select * from cliente;";
                            $result = mysqli_query($db, $sql);

                            if ($result) {
                                while ($data = mysqli_fetch_assoc($result)) {
                                    echo '<tr class= "gradeX">
                                    <td>' . $data["idCliente"] . ' </td>
                                    <td>' . $data["nombre"] . '</td>
                                    <td>' . $data["direccion"] . '</td>
                                    <td>' . $data["telefono"] . '</td>
                                    <td>' . $data["referencia"] . '</td>
                                    <td class="center">' . $data["Debe_dinero"] . '</td>
                                    <td class="center">' . $data["Debe_garrafon"] . '</td>
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

    <div class="modal fade none-border" id="nuevo-cliente">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo Cliente</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Nombre: </label>
                                <input class="form-control form-white" placeholder="-" type="text" id="nombreCliente" name="nombreCliente" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Dirección: </label>
                                <input class="form-control form-white" placeholder="-" type="text" id="direccionCliente" name="direccionCliente" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Teléfono: </label>
                                <input class="form-control form-white" placeholder="-" type="text" id="telCliente" name="telCliente" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Referencia: </label>
                                <input class="form-control form-white" placeholder="-" type="text" id="refCliente" name="refCliente" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger waves-effect waves-light save-category" name="submitCliente">Agregar</button>
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade none-border" id="rest-deuda">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pago de Deuda</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">ID cliente: </label>
                                <select class="form-control form-white" data-placeholder="Cliente..." name="clienteDinero">
                                        <?php
                                        $sql = "select * from cliente;";
                                        $result = mysqli_query($db, $sql);

                                        if ($result) {
                                            while ($data = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $data["idCliente"] . '">' . $data["idCliente"] . ' - ' .
                                                    $data["nombre"] . '</option>';
                                            }
                                        } else {
                                            echo "Error al cargar cliente.";
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Pago: </label>
                                <input class="form-control form-white" placeholder="Q" type="text" name="pagoDinero" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger waves-effect waves-light save-category" name="submitDinero">Agregar</button>
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade none-border" id="rest-garrafon">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Devolucion de Garrafon</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">ID cliente: </label>
                                <select class="form-control form-white" data-placeholder="Cliente..." name="clienteGarrafon">
                                        <?php
                                        $sql = "select * from cliente;";
                                        $result = mysqli_query($db, $sql);

                                        if ($result) {
                                            while ($data = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $data["idCliente"] . '">' . $data["idCliente"] . ' - ' .
                                                    $data["nombre"] . '</option>';
                                            }
                                        } else {
                                            echo "Error al cargar cliente.";
                                        }
                                        ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">No. Garrafones: </label>
                                <input class="form-control form-white" placeholder="#" type="text" name="devolGarrafon" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger waves-effect waves-light save-category" name="submitGarrafon">Agregar</button>
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>