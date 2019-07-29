var idPedidoGlobal = 0;

function sendInfo(nombre, direccion, telefono, referencia, observacion) {
    $("#infoNombre").text("Nombre: " + nombre);
    $("#infoDireccion").text("Dirección: " + direccion);
    $("#infoTelefono").text("Teléfono: " + telefono);
    $("#infoReferencia").text("Referencia: " + referencia);
    $("#infoObservacion").text("Descripcion: " + observacion);
    $('#info-user').modal();

}

function sendHecho(idPedido) {
    idPedidoGlobal = idPedido;
    $('#pedido-hecho').modal();

}

function sendCancelar(idPedido) {
    idPedidoGlobal = idPedido;
    $('#pedido-cancelar').modal();

}

function entregaPedidoClick() {

    var canceloQ = $('#entregaCancelo').val();
    var debeQ = $('#entregaDebeQ').val();
    var debeG = $('#entregaDebeG').val();
    $('#entregaCancelo').val('');
    $('#entregaDebeQ').val('');
    $('#entregaDebeG').val('');

    if (debeG == '' || debeG == null) {
        debeG = 0;
    }
    if (debeQ == '' || debeQ == null) {
        debeG = 0;
    }
    sendDataHecho(canceloQ, debeQ, debeG);
}

function cancelaPedidoClick() {

    var justificar = $('#cancelarJusti').val();
    $('#cancelarJusti').val('');
    sendDataCancelo(justificar);
}
var botonHecho = document.querySelector("#hechoBoton");


function sendDataHecho(cancelo, debeQ, debeG) {
    var varDiv = "#pedido" + idPedidoGlobal;

    postData = {
        "idPedido": idPedidoGlobal,
        "canceloQ": cancelo,
        "debeQ": debeQ,
        "debeG": debeG
    }
    $.post('ajaxPedido.php', {
        "Pedido": postData
    }, function(response) {
        alert(response);
    });
    $(varDiv).remove();
}

function sendDataCancelo(justificacion) {
    var varDiv = "#pedido" + idPedidoGlobal;

    postData = {
        "idPedido": idPedidoGlobal,
        "justCancelo": justificacion
    }

    $.post('ajaxCancelo.php', {
        "Pedido": postData
    }, function(response) {
        alert(response);
    });

    $(varDiv).remove();
}

$(document).ready(function() {

    function cerrarSesion() {
        var resultado = confirm("Seguro que quieres cerrar sesión?");
        console.log(resultado);
        if (resultado == true) {
            window.location.href = "login.php";
        }
    }


});

/*
var botonNuevo = document.querySelector("#newPedido");
var botonCancelar = document.querySelector("#addJust");
var botonEntrega = document.querySelector("#entregaPedido");

botonNuevo.addEventListener("click", function() {
    var cliente = document.querySelector("#comboCliente").value;
    var garrafon = document.querySelector("#nuevoGarrafon").value;
    var fardo = document.querySelector("#nuevoFardo").value;

    //Nuevo Pedido, con cliente, garrafon y fardo directo a la base de datos.
});

botonEntrega.addEventListener("click", function() {
    var pago = document.querySelector("#entregaCancelo").value;
    var debeDinero = document.querySelector("#entregaDebeQ").value;
    var debeGarrafon = document.querySelector("#entregaDebeG").value;

    //Entregó pedido, cúanto cancelo, debe dinero y debe garrafones.
});

botonCancelar.addEventListener("click", function() {
    var justificar = document.querySelector("#cancelarJusti").value;

    //Pedido Cancelado, justificación
});*/