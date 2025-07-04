/*global document: false */
function selectall() {
    $("input:checkbox").attr('checked', true);
    $("#botonenviar").attr("disabled", false);
}
function incrementara(a) {
    var id1 = 'item' + a;
    var cant = 'cant' + a;
    var cantidad = document.getElementById(cant);
    var valoract = parseInt(cantidad.value, 10);
    if (cantidad.value < 9)
        valor = valoract + 1;
    else
        valor = 0;
    var txt = document.getElementById(id1);
    txt.innerHTML = valor;
    cantidad.value = valor;
    var boton = document.getElementById("enviar");
    boton.disabled = false;
}
function decrementara(a) {
    var id1 = 'item' + a;
    var cant = 'cant' + a;
    var cantidad = document.getElementById(cant);
    var valoract = parseInt(cantidad.value, 10);
    if (cantidad.value > 0)
        valor = valoract - 1;
    else
        valor = 0;
    var txt = document.getElementById(id1);
    txt.innerHTML = valor;
    cantidad.value = valor;
    var boton = document.getElementById("enviar");
    boton.disabled = false;
}
function incrementar() {
    var valor = document.getElementById("item1"), ad1 = document.getElementById("ad1");
    if (valor.innerText < 9)
        valor.innerText++;
    if (ad1.value < 9)
        ad1.value++;
    boton = document.getElementById("enviar");
    if (ad1.value == 0 && ad2.value == 0)
        boton.disabled = true;
    else
        boton.disabled = false;
}
function incrementar2() {
    var valor = document.getElementById("item2"), ad2 = document.getElementById("ad2");
    if (valor.innerText < 9)
        valor.innerText++;
    if (ad2.value < 9)
        ad2.value++;
    boton = document.getElementById("enviar");
    if (ad2.value == 0 && ad1.value == 0)
        boton.disabled = true;
    else
        boton.disabled = false;
}
function decrementar() {
    var valor = document.getElementById("item1"), ad1 = document.getElementById("ad1");
    if (valor.innerText > 0)
        valor.innerText--;
    if (ad1.value > 0) {
        ad1.value--;
        boton = document.getElementById("enviar");
        if (ad1.value == 0 && ad2.value == 0)
            boton.disabled = true;
    }
    else
        boton.disabled = false;
}
function decrementar2() {
    var valor = document.getElementById("item2"), ad2 = document.getElementById("ad2");
    boton = document.getElementById("enviar");
    if (valor.innerText > 0)
        valor.innerText--;
    if (ad2.value > 0) {
        ad2.value--;
        if (ad2.value == 0 && ad1.value == 0)
            boton.disabled = true;
    }
    else
        boton.disabled = false;
}
function borrar(a, b, i) {
    event.preventDefault();
    var sesion = 0;
    var request = $.ajax({
        url: '/pedidos/check_session',
        type: 'POST',
        dataType: 'text',
        cache: false,
        data: { 'id_pedido': id_pedido }
    });
    request.done(function (msg) {
        if (msg != "true") {
            window.location.href = '/';
        }
        else {
            sesion = 1; // variable que avisa que la sesion está activa.
        }
    });
    var mensaje = "Está seguro de borrar el pedido de " + a + "- " + b + "??";
    var id_pedido = i;
    Swal.fire({
        title: mensaje,
        text: "No se puede revertir....",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, borrar'
    }).then(function (result) {
        if (result.value) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'success',
                title: 'Pedido Borrado correctamente!!'
            });
            navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
            navigator.vibrate(1000);
            var request = $.ajax({
                url: '/pedidos/borrar',
                type: 'POST',
                dataType: 'text',
                cache: false,
                data: { 'id_pedido': id_pedido }
            });
            request.done(function (msg) {
                window.location.href = '/pedidos';
            });
            request.fail(function (jqXHR, textStatus) {
                alert("Error : " + textStatus);
            });
        }
        else {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'warning',
                title: 'Error al borrar el pedido!!'
            });
        }
    });
}
function reimprimir(a) {
    event.preventDefault();
    var mensaje = "Está seguro de reimprimir la comanda numero " + a + "??";
    var id = a;
    Swal.fire({
        title: mensaje,
        text: "Reimpresion de comanda....",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, imprimir'
    }).then(function (result) {
        if (result.value) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'success',
                title: 'Comanda Reimpresa!!'
            });
            navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
            navigator.vibrate(1000);
            var request = $.ajax({
                url: '/reposicion/reimprimir',
                type: 'POST',
                dataType: 'text',
                cache: false,
                data: { 'id': id }
            });
            request.done(function (msg) {
                window.location.href = '/reposicion';
            });
            request.fail(function (jqXHR, textStatus) {
                alert("Error : " + textStatus);
            });
        }
        else {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'warning',
                title: 'Error al reimprimir!!'
            });
        }
    });
}
function enviar() {
    event.preventDefault();
    if (!$("#botonenviar").attr("disabled")) {
        var mensaje = "Se van a enviar los pedidos seleccionados ";
        var texto = "Se confirmará el envio a los locales";
        var peticiones = $("input[type=checkbox]:checked").length;
        Swal.fire({
            title: mensaje,
            text: texto,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, enviar'
        }).then(function (result) {
            if (result.value) {
                $("#cargando").show();
                $("#botonenviar").attr("disabled", true);
                $(".overlay").show();
                $("input[type=checkbox]:checked").each(function () {
                    //cada elemento seleccionado
                    var id_pedido = $(this).val();
                    var request = $.ajax({
                        url: '/pedidos/enviar',
                        type: 'POST',
                        dataType: 'text',
                        cache: false,
                        data: { 'id_pedido': id_pedido },
                        complete: function () {
                            peticiones--;
                            if (peticiones == 0) {
                                navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
                                navigator.vibrate([300, 300, 300]);
                                $(".overlay").hide();
                                var Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                Toast.fire({
                                    type: 'success',
                                    title: 'Pedido enviado correctamente!!'
                                });
                                window.location.href = '/enviar';
                                $("#botonenviar").attr("disabled", false);
                            }
                        }
                    });
                });
                request.done(function (msg2) {
                    if (request.value != false) {
                    }
                    else {
                        var Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            type: 'warning',
                            title: 'Error al cargar el pedido!!'
                        });
                        setTimeout(function () {
                            window.location.href = '/';
                        }, 1500);
                    }
                });
                request.fail(function (jqXHR, textStatus) {
                    alert("Request failed: " + textStatus);
                });
            }
        });
    }
}
function modificar(a, b) {
    event.preventDefault();
    var sesion = 0;
    var request = $.ajax({
        url: '/pedidos/check_session',
        type: 'POST',
        dataType: 'text',
        cache: false,
        data: { 'id_pedido': id_pedido }
    });
    request.done(function (msg) {
        if (msg != "true") {
            window.location.href = '/';
        }
        else {
            sesion = 1; // variable que avisa que la sesion está activa.
        }
    });
    var id_pedido = a;
    var id_articulo = b;
    var id = "cantidad" + a;
    valor = document.getElementById(id);
    cantidad = valor.value;
    navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
    navigator.vibrate(400);
    $("#cargando").show();
    var request = $.ajax({
        url: '/pedidos/modificar',
        type: 'POST',
        dataType: 'text',
        cache: false,
        data: { 'id_pedido': id_pedido, 'id_articulo': id_articulo, 'cantidad': cantidad }
    });
    request.done(function (msg2) {
        $("#contenido").show();
        $("#posts").append("<li><p> Se modificó cantidad al pedido " + id_pedido + "</p></li>");
        $("#cargando").hide();
        //window.location.href = 'http://pedidoslomas.ddns.net/enviar';
    });
    request.fail(function (jqXHR, textStatus) {
        alert("Request failed: " + textStatus);
    });
}
function confirma() {
    event.preventDefault();
    var sesion = 0;
    var mensaje = "Se va a enviar el pedido";
    var texto = "Está seguro de confirmar el pedido";
    var request = $.ajax({
        url: '/pedidos/check_session',
        type: 'POST',
        dataType: 'text',
        cache: false,
        data: { 'id_pedido': 0 }
    });
    request.done(function (msg) {
        if (msg != "true") {
            window.location.href = '/';
        }
        else {
            sesion = 1; // variable que avisa que la sesion está activa.
        }
    });
    Swal.fire({
        title: mensaje,
        text: texto,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, enviar'
    }).then(function (result) {
        if (result.value) {
            navigator.vibrate = navigator.vibrate || navigator.webkitVibrate || navigator.mozVibrate || navigator.msVibrate;
            navigator.vibrate([150, 150, 150, 150, 150]);
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'success',
                title: 'Pedido enviado correctamente!!'
            });
            setTimeout(function () {
                document.pedido.submit();
            }, 1500);
        }
        else {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'warning',
                title: 'Error al cargar el pedido!!'
            });
        }
    });
}
function confirmarepo() {
    event.preventDefault();
    var sesion = 0;
    var mensaje = "Se va a enviar la reposición";
    var texto = "Está seguro de confirmar el pedido";
    Swal.fire({
        title: mensaje,
        text: texto,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, enviar'
    }).then(function (result) {
        if (result.value) {
            document.repo.submit();
        }
        else {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            Toast.fire({
                type: 'warning',
                title: 'Error al cargar el pedido!!'
            });
        }
    });
} // fin de CONFIRMAREPO
$(document).ready(function () {
    if ($("input[type=checkbox]:checked").length == 0) {
        $("#botonenviar").attr("disabled", true);
    }
    $("input[type=checkbox]").on('change', function () {
        if ($("input[type=checkbox]:checked").length == 0) {
            $("#botonenviar").attr("disabled", true);
        }
        else {
            $("#botonenviar").attr("disabled", false);
        }
    });
    $('#seleccionartodo').click(function () { selectall(); return false; });
    $('body').on('click', '#btnart', function (event) {
        event.preventDefault();
        var datos = $(this).data("id");
        incrementara(datos);
    });
    $('body').on('click', '#btndesc', function (event) {
        event.preventDefault();
        var datos = $(this).data("id");
        decrementara(datos);
    });
});
