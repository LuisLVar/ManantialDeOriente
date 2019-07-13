<?php
include('session.php');
?>
   <?php
    if (isset($_POST['Pedido'])) {
        $Pedido =  $_POST['Pedido'];
        $idPedido = $Pedido["idPedido"];
        $cancelo = $Pedido["canceloQ"];
        $debeQ = $Pedido["debeQ"];
        $debeG = $Pedido["debeG"];
        //echo "alert($idPedido);";
        //$sql = "SELECT idUsuario FROM usuario WHERE usuario = '$myusername' and password = '$mypassword'";
        //update cliente set Debe_dinero = suma1, Debe_garrafon = suma2 where idCliente = id;
        //select C.Debe_dinero, C.Debe_garrafon, P.fCliente from pedido P inner join cliente C on P.fCliente = C.idCliente where P.idPedido = 5;


        $sql = "update pedido set cancelo = $cancelo, debeQ = $debeQ, DebeGarrafon = $debeG, Estado = 'ENTREGADO' where idPedido = $idPedido;";
        $result = mysqli_query($db, $sql);
        


        $sql1 = "select C.Debe_dinero, C.Debe_garrafon, P.fCliente from pedido P inner join cliente C on P.fCliente = 
        C.idCliente where P.idPedido = $idPedido;";
        $result1 = mysqli_query($db, $sql1);
        $data = mysqli_fetch_assoc($result1);

        $idCliente = $data["fCliente"];
        $sumaDinero = $data["Debe_dinero"] + $debeQ;
        $sumaGarrafon = $data["Debe_garrafon"] + $debeG;

        if (!$result1) {
            echo "Fallo al tomar datos del Cliente";
        }

        $sql2 = "update cliente set Debe_dinero = $sumaDinero, Debe_garrafon = $sumaGarrafon where idCliente = $idCliente;";
        $result2 = mysqli_query($db, $sql2);

        if (!$result2) {
            echo "Fallo al sumar deuda";
        }

        if ($result) {
            echo "Exito al procesar pedido.";
        } else {
            echo "Error al procesar pedido.";
        }
    }
    ?>