
var producto = $("#producto");
var stock = $("#stock");
var undmedida = $("#und_medida");

$(document).ready(function(){

    
 
});

$(document).on("click","#btnagregar",function(){
    var refaccion = $("#producto").val();
    var preciocompra = $("#precio_compra").val();
    var cantidad = $("#detc_cant").val();


        $.post("../../controller/ctrCompra.php?op=registrardetalle",{
            refaccion:refaccion,
            preciocompra:preciocompra,
            cantidad:cantidad
        },function(data){
            console.log(data);
        });

});

function eliminar(detc_id,compr_id){

    swal.fire({
        title:"Eliminar!",
        text:"Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText : "Si",
        showCancelButton : true,
        cancelButtonText: "No",
    }).then((result)=>{
        if (result.value){
            $.post("../../controller/compra.php?op=eliminardetalle",{detc_id:detc_id},function(data){
                console.log(data);
            });

            $.post("../../controller/compra.php?op=calculo",{compr_id:compr_id},function(data){
                data=JSON.parse(data);
                $('#txtsubtotal').html(data.COMPR_SUBTOTAL);
                $('#txtigv').html(data.COMPR_IGV);
                $('#txttotal').html(data.COMPR_TOTAL);
            });

            listar(compr_id);

            swal.fire({
                title:'Compra',
                text: 'Registro Eliminado',
                icon: 'success'
            });
        }
    });

}

// function listar(compr_id){
//     $('#table_data').DataTable({
//         "aProcessing": true,
//         "aServerSide": true,
//         dom: 'Bfrtip',
//         buttons: [
//             'copyHtml5',
//             'excelHtml5',
//             'csvHtml5',
//         ],
//         "ajax":{
//             url:"../../controller/compra.php?op=listardetalle",
//             type:"post",
//             data:{compr_id:compr_id}
//         },
//         "bDestroy": true,
//         "responsive": true,
//         "bInfo":true,
//         "iDisplayLength": 10,
//         "order": [[ 0, "desc" ]],
//         "language": {
//             "sProcessing":     "Procesando...",
//             "sLengthMenu":     "Mostrar _MENU_ registros",
//             "sZeroRecords":    "No se encontraron resultados",
//             "sEmptyTable":     "Ningún dato disponible en esta tabla",
//             "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
//             "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
//             "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
//             "sInfoPostFix":    "",
//             "sSearch":         "Buscar:",
//             "sUrl":            "",
//             "sInfoThousands":  ",",
//             "sLoadingRecords": "Cargando...",
//             "oPaginate": {
//                 "sFirst":    "Primero",
//                 "sLast":     "Último",
//                 "sNext":     "Siguiente",
//                 "sPrevious": "Anterior"
//             },
//             "oAria": {
//                 "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
//                 "sSortDescending": ": Activar para ordenar la columna de manera descendente"
//             }
//         },
//     });
// }

$(document).on("click","#btnguardar",function(){
    var compr_id = $("#compr_id").val();
    var doc_id = $("#doc_id").val();
    var pag_id = $("#pag_id").val();
    var prov_id = $("#prov_id").val();
    var prov_ruc = $("#prov_ruc").val();
    var prov_direcc = $("#prov_direcc").val();
    var prov_correo = $("#prov_correo").val();
    var compr_coment = $("#compr_coment").val();
    var mon_id = $("#mon_id").val();

    if($("#doc_id").val()=='0' || $("#pag_id").val()=='0' || $("#prov_id").val()=='0' || $("#mon_id").val()=='0'){
        /* TODO:Validacion de Pago , Proveedor , Moneda */
        swal.fire({
            title:'Compra',
            text: 'Error Campos Vacios',
            icon: 'error'
        });

    }else{
        $.post("../../controller/compra.php?op=calculo",{compr_id:compr_id},function(data){
            data=JSON.parse(data);
            console.log(data);
            if (data.COMPR_TOTAL==null){
                /* TODO:Validacion de Detalle */
                swal.fire({
                    title:'Compra',
                    text: 'Error No Existe Detalle',
                    icon: 'error'
                });

            }else{
                $.post("../../controller/compra.php?op=guardar",{
                    compr_id:compr_id,
                    pag_id:pag_id,
                    prov_id:prov_id,
                    prov_ruc:prov_ruc,
                    prov_direcc:prov_direcc,
                    prov_correo:prov_correo,
                    compr_coment:compr_coment,
                    mon_id:mon_id,
                    doc_id:doc_id
                },function(data){
                    /* TODO:Mensaje de Sweetalert */
                    swal.fire({
                        title:'Compra',
                        text: 'Compra registrada Correctamente con Nro: C-'+compr_id,
                        icon: 'success',
                        /* TODO: Ruta para mostrar documento de compra */
                        footer: "<a href='../ViewCompra/?c="+compr_id+"' target='_blank'>Desea ver el Documento?</a>"
                    });

                });
            }

        });

    }

});

$(document).on("click","#btnlimpiar",function(){
    location.reload();
});


$(producto).on("change", function(){

    $.ajax({
        url: "../../controller/ctrRefacciones.php?op=mostrar",
        type: "POST",
        data: { token: producto.val() },
        dataType: "json",
        success: function (response) {
          stock.val(response["stock"]);
          undmedida.val(response["unidadmedida"]);
        },
        error: function (xhr, status, error) {
          console.error("Error en la petición AJAX:", error);
          Swal.fire("Error", "Ocurrió un error al procesar la solicitud.", "error");
        }
    });
});


//     $.ajax({
//         url: "../../controller/ctrProveedor.php?op=mostrar",
//         type: "POST",
//         data: { token: proveedor.val() },
//         dataType: "json",
//         success: function (response) {
//           rfc.val(response["rfc"]);
//           telefono.val(response["telefono"]);
//           correo.val(response["email"]);
//         },
//         error: function (xhr, status, error) {
//           console.error("Error en la petición AJAX:", error);
//           Swal.fire("Error", "Ocurrió un error al procesar la solicitud.", "error");
//         }
//     });
// });