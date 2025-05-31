//mostrar datos de la compra
$(document).ready(function(){
    var compra_id = getUrlParameter('c');

    $.post("../../controller/ctrCompra.php?op=mostrar",{compra_id:compra_id},function(data){
        data=JSON.parse(data);
        $('#compra_id').html(data.compra_id);
        $('#fech_crea').html(data.fech_crea);
        // $('#pag_nom').html(data.PAG_NOM);
        $('#compra_total').html(data.compra_total);

        // $('#compr_subtotal').html(data.COMPR_SUBTOTAL);
        // $('#compr_igv').html(data.COMPR_IGV);
        // $('#compr_total').html(data.COMPR_TOTAL);

        // $('#compra_coment').html(data.compra_coment);

         $('#usu_nom').html(data.usu_nom);

        $('#prov_id').html("<b>Nombre: </b>"+data.prov_id);
        $('#prov_rfc').html("<b>RUC: </b>"+data.prov_rfc);
        $('#prov_direccion').html("<b>Dirección: </b>"+data.prov_direccion);
        $('#prov_correo').html("<b>Correo: </b>"+data.prov_correo);

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