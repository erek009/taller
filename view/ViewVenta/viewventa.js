//mostrar datos de la compra
$(document).ready(function(){
    var venta_id = getUrlParameter('v');

    $.post("../../controller/ctrVenta.php?op=mostrarDatosVenta",{venta_id:venta_id},function(data){
        data=JSON.parse(data);
        $('#venta_id').html(data.venta_id);
        $('#fech_crea').html(data.fech_crea);
        $('#totalpago').html(data.venta_total);
        
        $('#clie_id').html("<b>Nombre: </b>"+data.clie_id);
        $('#clie_direccion').html("<b>Dirección: </b>"+data.clie_direccion);
        $('#clie_telefono').html("<b>Correo: </b>"+data.clie_telefono);

        $('#usu_nom').html(data.usu_nom);

        $('#venta_subtotal').html(data.venta_subtotal);
        $('#venta_iva').html(data.venta_iva);
        $('#venta_total').html(data.venta_total);

        $('#venta_comentario').html(data.venta_comentario);

    });

    $.post("../../controller/ctrVenta.php?op=listarDetalleProductosVenta",{venta_id:venta_id},function(data){
         $('#listdetalle').html(data);
    });
});


/* TODO: Obtener parametro de URL */
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};