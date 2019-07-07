function cerrarSesion() {
    var resultado = confirm("Seguro que quieres cerrar sesión?");
    console.log(resultado);
    if (resultado == true) {
        window.location.href = "login.html";
    }
}

function iniciarSesion() {
    var user = document.getElementById("inputEmail").value;
    var pass = document.getElementById("inputPassword").value;

    if (user == "admin" && pass == "pass") {
        window.location.href = "pedidos.html";
    } else if (user == "usuario1" && pass == "manantial") {
        window.location.href = "pedidostr.html";
    } else {
        alert("Usuario incorrecto");
        document.getElementById("inputEmail").value = "";
        document.getElementById("inputPassword").value = "";
    }
}

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
});