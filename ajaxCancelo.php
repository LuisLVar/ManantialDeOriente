<?php
   include('session.php');
?>
<?php 
if(isset($_POST['Pedido'])){
    $Pedido =  $_POST['Pedido'];
    $idPedido = $Pedido["idPedido"];
    $justificacion = $Pedido["justCancelo"];
    
    //echo "alert($idPedido);";
        //$sql = "SELECT idUsuario FROM usuario WHERE usuario = '$myusername' and password = '$mypassword'";
        //
        $sql = "update pedido set Observacion = '$justificacion', Estado = 'CANCELADO' where idPedido = $idPedido;";
        $result = mysqli_query($db, $sql);
        if ($result) {
            //header("Location: pedido.php");
            echo "Exito al procesar pedido.";
        } else {
            echo "Error al procesar pedido.";
        }
}
?>