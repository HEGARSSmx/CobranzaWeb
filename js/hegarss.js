function muestraMensaje(mensaje,tipo){
    var n = noty({
        theme: 'bootstrapTheme',
        type: tipo,
        text: mensaje,
        layout: 'topRight',
        animation: {
            open: 'animated bounceIn',
            close: 'animated bounceOut',
            easing: 'swing',
            speed: 500
        },
        dismissQueue: true,
        timeout: 9000
    });
}

function getCliente(idCliente){
    // mandamos buscar el cliente
    $.ajax({
        type: 'POST',
        url: "/Cobranza/php/Funciones.php",
        data: "function=getClienteById&idCliente="+idCliente,
        cache: false,
        dataType: 'json',
        success: function (data) {
            return JSON.parse(data);
        },
        error: function () {
            muestraMensaje("<span style='color:#cc0000'>Error Interno en el servidor, vuelva a intentarlo</span> ", "error");
        }
    });
    
}