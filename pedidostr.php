<?php
include('session.php');
if ($_SESSION['login_user'] != "usuario1") {
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
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <!-- Funciones JS-->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js "></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js "></script>
    <script src="funciones.js "></script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="pedidostr.php">Pedidos</a>
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

    <section>
        <br><br>
        <button href="javascript:void(0)" data-toggle="modal" data-target="#nuevo-pedido" class="btn m-t-20 btn-info btn-block waves-effect waves-light">
            <i class="ti-plus"></i> Agregar Nuevo Pedido
        </button>
    </section>

    <!-- Icons Grid -->
    <section class="bg-light text-center">
        <div><br><br>
            <?php
            if (isset($_POST['submitPedido'])) {
                $nameCliente = mysqli_real_escape_string($db, $_POST['comboCliente']);
                $nameClienteX = mysqli_real_escape_string($db, $_POST['nameClienteX']);
                $noGarrafon = mysqli_real_escape_string($db, $_POST['nuevoGarrafon']);
                $noFardo = mysqli_real_escape_string($db, $_POST['nuevoFardo']);
                $descripcion = mysqli_real_escape_string($db, $_POST['nuevaDescripcion']);
                $date = new DateTime("now", new DateTimeZone('America/Guatemala'));
                $dateFinal = $date->format('d/m/Y H:i');

                if ($noGarrafon == '') {
                    $noGarrafon = 0;
                }
                if ($noFardo == '') {
                    $noFardo = 0;
                }
                //echo "document.alert(\"$nameCliente, $noGarrafon, $noFardo, $descripcion\");";

                //$sql = "SELECT idUsuario FROM usuario WHERE usuario = '$myusername' and password = '$mypassword'";
                //DATE_FORMAT(now(),'%d/%m/%Y %H:%i')

                $sql = "insert into pedido values(0, '$dateFinal', $nameCliente, '$nameClienteX', $noGarrafon, $noFardo, 0, 0, 0, '$descripcion', 'ESPERA');";
                $result = mysqli_query($db, $sql);
                if ($result) {
                    echo "<hr><p><b><span style=\"color:#64C50E\";> Pedido ingresado exitosamente. </span></b></p><hr>";
                } else {
                    echo "<hr><p><b><span style=\"color:red\";> Error al ingresar pedido. </span></b></p><hr>";
                }
            }
            ?>
            <div>
                <div class="container">
                    <div class="row">
                        <?php

                        $sql = "select P.idPedido,C.nombre, C.direccion, C.telefono, C.referencia, P.fCliente, P.cantidadGarrafon, 
                        P.cantidadFardo, P.clienteX, P.observacion from pedido P inner join cliente C on P.fCliente = C.idCliente where P.Estado = 'ESPERA' order by P.idPedido";
                        $result = mysqli_query($db, $sql);
                        //onclick = "sendInfo(' . $data["idPedido"] .')
                        if ($result) {
                            //, '.$data["direccion"].', ' . $data["telefono"].', '.$data["referencia"].'
                            //Pedido Hecho y Pedido cancelar enviarlos a otra pagina php.
                            while ($data = mysqli_fetch_assoc($result)) {
                                echo '<div class="col-lg-3" style="border:2px solid #1CB7C0; margin:5px; padding-top:5px;" id="pedido' . $data["idPedido"] . '">
                                <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                                    <h6 class="font-medium" value="' . $data["fCliente"] . '" name="idCliente">' . $data["fCliente"] . ' - ' . $data["nombre"] . '</h6>';
                                    if($data["clienteX"] != ""){
                                       echo '<span value="' . $data["clienteX"] . '" name="nombreClienteX">Cliente: ' . $data["clienteX"] . '<br></span>';
                                    }
                                    echo '<span value="' . $data["idPedido"] . '" name="idPedido">ID Pedido: ' . $data["idPedido"] . '<br></span>
                                    <span value="' . $data["cantidadGarrafon"] . '" name="noGarrafon">Garrafones: ' . $data["cantidadGarrafon"] . '<br></span>
                                    <span value="' . $data["cantidadFardo"] . '" name="noFardos">Fardos: ' . $data["cantidadFardo"] . ' <br></span>
                                    <span value="' . $data["observacion"] . '" name="DataObservacion">Descripcion: ' . $data["observacion"] . ' </span>
                                    <div class="comment-footer">
                                        <button type="button" class="btn btn-primary btn-sm" onclick = "sendInfo(\'' . $data["nombre"] . '\'
                                        , \'' . $data["direccion"] . '\', \'' . $data["telefono"] . '\', \'' . $data["referencia"] . '\'
                                        , \'' . $data["observacion"] . '\')">Información</button>
                                        <button type="button" class="btn btn-success btn-sm" onclick = "sendHecho(' . $data["idPedido"] . ')">Entregar</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick = "sendCancelar(' . $data["idPedido"] . ')">Cancelar</button>
                                    </div>
                                </div>
                            </div>';
                            }
                        } else {
                            echo "Error al cargar cliente.";
                        }
                        ?>
                    </div>
                </div>
                <div><br><br><br><br>
                    <div>
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
    <!-- Modal Información de  Cliente -->
    <div class="modal fade none-border" id="info-user">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cliente: </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label" id="infoNombre"> </label>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label" id="infoDireccion"></label>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label" id="infoTelefono"></label>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label" id="infoReferencia"></label>
                            </div>
                            <div class="col-md-12">
                                <label class="control-label" id="infoObservacion"></label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Pedido Entregado -->
    <div class="modal fade none-border" id="pedido-hecho">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pedido Entregado</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Cancelo: </label>
                                <input class="form-control form-white" placeholder="Q" type="text" id="entregaCancelo" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Debe: </label>
                                <input class="form-control form-white" placeholder="Q" type="text" id="entregaDebeQ" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Debe Garrafones: </label>
                                <input class="form-control form-white" placeholder="Cantidad" type="text" id="entregaDebeG" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="entregaPedido" onclick="entregaPedidoClick()" data-dismiss="modal">Agregar</button>
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Pedido cancelado -->
    <div class="modal fade none-border" id="pedido-cancelar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Cancelar Pedido</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Justificación: </label>
                                <input class="form-control form-white" placeholder="Por Qué?" type="text" id="cancelarJusti" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger waves-effect waves-light save-category" id="cancelarPedido" onclick="cancelaPedidoClick()" data-dismiss="modal">Agregar</button>
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- NUEVO PEDIDO-->
    <div class="modal fade none-border" id="nuevo-pedido">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nuevo Pedido</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Cliente:</label>
                                <input class="form-control form-white" data-placeholder="Cliente..." list="listaPedido" name="comboCliente">
                                <datalist id="listaPedido">
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
                                </datalist>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Nombre Cliente X: </label>
                                <input class="form-control form-white" placeholder="Cliente X" type="text" name="nameClienteX" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Cantidad de Garrafones: </label>
                                <input class="form-control form-white" placeholder="Unidades" type="text" name="nuevoGarrafon" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Cantidad de fardos: </label>
                                <input class="form-control form-white" placeholder="Unidades" type="text" name="nuevoFardo" />
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Descripcion: </label>
                                <input class="form-control form-white" placeholder="..." type="text" name="nuevaDescripcion" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger waves-effect waves-light save-category" name="submitPedido">Agregar</button>
                            <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>