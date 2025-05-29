var usu_id = $("#token_usu").val();

var proveedor = $("#proveedor");
var rfc = $("#rfc");
var direccion = $("#prov_direccion");
var correo = $("#prov_correo");
var telefono = $("#prov_telefono");

var categoria = $("#categoria");
var producto = $("#producto");
var stock = $("#stock");
var undmedida = $("#und_medida");
var preciocompra = $("#precio_compra");


// Inicializa el DataTable para mostrar los detalles de la compra
$(document).ready(function () {

$.post("../../controller/ctrCompra.php?op=registrar",{usu_id:usu_id},function(data){
         data=JSON.parse(data);
         $('#compra_id').val(data.compra_id);
    });

});


// Agrega un nuevo detalle de compra
$(document).on("click", "#btnagregar", function () {
  var categoria = $("#categoria").val();
  var refaccion = $("#producto").val();
  var compra_id = $("#compra_id").val();
  var preciocompra = $("#precio_compra").val();
  var unidadmedida = $("#und_medida").val();
  var cantidad = $("#detc_cant").val();

  $.post(
    "../../controller/ctrCompra.php?op=registrardetallecompra",
    {
      categoria: categoria,
      refaccion: refaccion,
      compra_id: compra_id,
      unidadmedida: unidadmedida,
      preciocompra: preciocompra,
      cantidad: cantidad,
    },
    function (data) {
      console.log("Detalle registrado:", data);

      // ✅ Solo hacer el cálculo DESPUÉS de registrar exitosamente el detalle
      $.post("../../controller/ctrCompra.php?op=calculo", { compra_id: compra_id }, function (data) {
        data = JSON.parse(data);
        $('#precio_subtotal').html(data.compra_subtotal);
        $('#precio_iva').html(data.compra_iva);
        $('#precio_total').html(data.compra_total);
      });

      // ✅ Actualizar campos relacionados (como tabla de productos o formulario)
      listar(refaccion);
    }
  );
});

// Elimina un detalle de compra
function eliminar(detalle_id) {
  swal
    .fire({
      title: "Eliminar!",
      text: "Desea Eliminar el Registro?",
      icon: "error",
      confirmButtonText: "Si",
      showCancelButton: true,
      cancelButtonText: "No",
    })
    .then((result) => {
      if (result.value) {
        $.post(
          "../../controller/ctrCompra.php?op=eliminar",
          { detalle_id: detalle_id },
          function (data) {
            console.log(data);

            // ✅ Recargar tabla
            $("#table_data").DataTable().ajax.reload();

            // ✅ Mostrar mensaje
            swal.fire({
              title: "Producto",
              text: "Registro Eliminado",
              icon: "success",
            });

            // ✅ Recalcular totales
            // Necesitas tener el ID de la compra disponible aquí
            var compra_id = $("#compra_id").val(); // Asegúrate de que este ID exista en tu HTML

            $.post(
              "../../controller/ctrCompra.php?op=calculo",
              { compra_id: compra_id },
              function (data) {
                data = JSON.parse(data);
                $('#precio_subtotal').html(data.compra_subtotal);
                $('#precio_iva').html(data.compra_iva);
                $('#precio_total').html(data.compra_total);
              }
            );
          }
        );
      }
    });
}




$(document).on("click", "#btnguardar", function () {
  var compr_id = $("#compr_id").val();
  var doc_id = $("#doc_id").val();
  var pag_id = $("#pag_id").val();
  var prov_id = $("#prov_id").val();
  var prov_ruc = $("#prov_ruc").val();
  var prov_direcc = $("#prov_direcc").val();
  var prov_correo = $("#prov_correo").val();
  var compr_coment = $("#compr_coment").val();
  var mon_id = $("#mon_id").val();

  if (
    $("#doc_id").val() == "0" ||
    $("#pag_id").val() == "0" ||
    $("#prov_id").val() == "0" ||
    $("#mon_id").val() == "0"
  ) {
    /* TODO:Validacion de Pago , Proveedor , Moneda */
    swal.fire({
      title: "Compra",
      text: "Error Campos Vacios",
      icon: "error",
    });
  } else {
    $.post(
      "../../controller/compra.php?op=calculo",
      { compr_id: compr_id },
      function (data) {
        data = JSON.parse(data);
        console.log(data);
        if (data.COMPR_TOTAL == null) {
          /* TODO:Validacion de Detalle */
          swal.fire({
            title: "Compra",
            text: "Error No Existe Detalle",
            icon: "error",
          });
        } else {
          $.post(
            "../../controller/compra.php?op=guardar",
            {
              compr_id: compr_id,
              pag_id: pag_id,
              prov_id: prov_id,
              prov_ruc: prov_ruc,
              prov_direcc: prov_direcc,
              prov_correo: prov_correo,
              compr_coment: compr_coment,
              mon_id: mon_id,
              doc_id: doc_id,
            },
            function (data) {
              /* TODO:Mensaje de Sweetalert */
              swal.fire({
                title: "Compra",
                text: "Compra registrada Correctamente con Nro: C-" + compr_id,
                icon: "success",
                /* TODO: Ruta para mostrar documento de compra */
                footer:
                  "<a href='../ViewCompra/?c=" +
                  compr_id +
                  "' target='_blank'>Desea ver el Documento?</a>",
              });
            }
          );
        }
      }
    );
  }
});

$(document).on("click", "#btnlimpiar", function () {
  location.reload();
});

// Cuando cambie la categoría, carga los productos de esa categoría
$("#categoria").on("change", function () {
  let categoriaID = $(this).val();

  if (categoriaID !== "") {
    $.ajax({
      url: "../../controller/ctrRefacciones.php?op=productos_por_categoria",
      type: "POST",
      data: { categoria_id: categoriaID },
      dataType: "json",
      success: function (productos) {
        let opciones = '<option value="">Seleccione un producto</option>';
        productos.forEach(function (p) {
          opciones += `<option value="${p.token}">${p.nombre}</option>`;
        });
        $("#producto").html(opciones);
      },
      error: function (xhr, status, error) {
        console.error("Error en la petición AJAX:", error);
        Swal.fire(
          "Error",
          "Ocurrió un error al cargar los productos.",
          "error"
        );
      },
    });
  } else {
    $("#producto").html('<option value="">Seleccione un producto</option>');
  }
});

// Cuando cambie el producto, carga sus datos
$("#producto").on("change", function () {
  let token = $(this).val();

  if (token !== "") {
    $.ajax({
      url: "../../controller/ctrRefacciones.php?op=mostrar",
      type: "POST",
      data: { token: token },
      dataType: "json",
      success: function (response) {
        $("#stock").val(response["stock"]);
        undmedida.val(response["unidadmedida"]);
        preciocompra.val(response["preciocompra"]);
      },
      error: function (xhr, status, error) {
        console.error("Error en la petición AJAX:", error);
        Swal.fire(
          "Error",
          "Ocurrió un error al procesar la solicitud.",
          "error"
        );
      },
    });
  } else {
    $("#stock").val("");
    $("#undmedida").val("");
    $("#preciocompra").val("");
  }
});

//muestra datos del proveedor
$(proveedor).on("change", function () {
  $.ajax({
    url: "../../controller/ctrProveedor.php?op=mostrar",
    type: "POST",
    data: { token: proveedor.val() },
    dataType: "json",
    success: function (response) {
      rfc.val(response["rfc"]);
      direccion.val(response["direccion"]);
      correo.val(response["email"]);
      telefono.val(response["telefono"]);
    },
    error: function (xhr, status, error) {
      console.error("Error en la petición AJAX:", error);
      Swal.fire("Error", "Ocurrió un error al procesar la solicitud.", "error");
    },
  });
});

function listar(compra_id) {
   var compra_id = $("#compra_id").val();
  /* TODO: Listar informacion en el datatable js */
  $("#table_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    buttons: ["copyHtml5", "excelHtml5", "csvHtml5"],
    ajax: {
      url: "../../controller/ctrCompra.php?op=listar",
      type: "post",
      data: { compra_id: compra_id },
    },
    bDestroy: true,
    responsive: true,
    bInfo: true,
    iDisplayLength: 10,
    order: [[0, "desc"]],
    language: {
      sProcessing: "Procesando...",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
  });
}
