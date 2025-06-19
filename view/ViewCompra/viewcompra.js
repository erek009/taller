//mostrar datos de la compra
$(document).ready(function(){
    var compra_id = getUrlParameter('c');

    $.post("../../controller/ctrCompra.php?op=mostrarDatosCompra",{compra_id:compra_id},function(data){
        data=JSON.parse(data);
        $('#compra_id').html(data.compra_id);
        $('#fech_crea').html(data.fech_crea);
        $('#totalpago').html(data.compra_total);
        
        $('#prov_id').html("<b>Nombre: </b>"+data.prov_id);
        $('#prov_rfc').html("<b>RFC: </b>"+data.prov_rfc);
        $('#prov_direccion').html("<b>Dirección: </b>"+data.prov_direccion);
        $('#prov_correo').html("<b>Correo: </b>"+data.prov_correo);

        $('#usu_nom').html(data.usu_nom);

        $('#compra_subtotal').html(data.compra_subtotal);
        $('#compra_iva').html(data.compra_iva);
        $('#compra_total').html(data.compra_total);

        $('#compra_comentario').html(data.compra_comentario);

    });

    $.post("../../controller/ctrCompra.php?op=listarDetalleProductosCompra",{compra_id:compra_id},function(data){
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