var usu_id = $("#token_usu").val();

// Variables cliente
var cliente = $("#cliente_id");
var direccion = $("#cli_direccion");
var telefono = $("#cli_telefono");

//variables productos
var categoria = $("#categoria");
var producto = $("#producto");
var stock = $("#stock");
var undmedida = $("#und_medida");
var precioventa = $("#precio_venta");


$(document).ready(function () {
  //registra id de venta 01
  $.post("../../controller/ctrVenta.php?op=registrar",{ usu_id: usu_id },
    function (data) {
      data = JSON.parse(data);
      $("#venta_id").val(data.venta_id);
    }
  );
    
});

// Agrega un nuevo detalle de compra
$(document).on("click", "#btnagregar", function () {
  var categoria = $("#categoria").val();
  var refaccion = $("#producto").val();
  var venta_id = $("#venta_id").val();
  var precioventa = $("#precio_venta").val();
  var unidadmedida = $("#und_medida").val();
  var cantidad = $("#detc_cant").val();

  // Validación de campos vacíos
  if (
    $("#categoria").val() == "" ||
    $("#producto").val() == "" ||
    $("#precio_venta").val() == "" ||
    $("#detc_cant").val() == ""
  ) {
    // Mostrar mensaje de error si falta información
    Swal.fire({
      title: "Error",
      text: "Todos los campos son obligatorios.",
      icon: "warning",
    });
  } else {
    // Enviar datos al servidor si todo está bien
    $.post(
      "../../controller/ctrVenta.php?op=registrardetalleproductos",
      {
        categoria: categoria,
        refaccion: refaccion,
        venta_id: venta_id,
        unidadmedida: unidadmedida,
        precioventa: precioventa,
        cantidad: cantidad,
      },
      function (data) {

        if (data === "error-stockinsuficiente") {
          Swal.fire({
            title: "Error",
            text: "No hay suficiente stock para esta refacción.",
            icon: "error",
          });
          return; 
        }

        console.log("Detalle registrado:", data);
        
        // Calcular subtotal/iva/total después de cada registro
         $.post(
           "../../controller/ctrVenta.php?op=calculo",
           { venta_id: venta_id },
           function (data) {
             data = JSON.parse(data);
             $("#precio_subtotal").html(data.venta_subtotal);
             $("#precio_iva").html(data.venta_iva);
             $("#precio_total").html(data.venta_total);
           }
         );

        // // limpiar campos después de agregar el detalle
         $("#precio_venta").val("");
         $("#detc_cant").val("");

        // Actualizar listado
         listar(venta_id);
      }
    );
  }
});

//listado de productos
function listar(venta_id) {
  var venta_id = $("#venta_id").val();
  /* TODO: Listar informacion en el datatable js */
  $("#table_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    buttons: ["copyHtml5", "excelHtml5", "csvHtml5"],
    ajax: {
      url: "../../controller/ctrVenta.php?op=listar",
      type: "post",
      data: { venta_id: venta_id },
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
          "../../controller/ctrVenta.php?op=eliminar",
          { detalle_id: detalle_id },
          function (data) {
            console.log(data);

            // Recargar tabla
            $("#table_data").DataTable().ajax.reload();

            // confirmación de eliminación
            swal.fire({
              title: "Producto",
              text: "Registro Eliminado",
              icon: "success",
            });

            //Recalcular $$ totales
            var venta_id = $("#compra_id").val();
            $.post(
              "../../controller/ctrCompra.php?op=calculo",
              { venta_id: venta_id },
              function (data) {
                data = JSON.parse(data);
                $("#precio_subtotal").html(data.compra_subtotal);
                $("#precio_iva").html(data.compra_iva);
                $("#precio_total").html(data.compra_total);
              }
            );
          }
        );
      }
    });
}

//guarda la venta
$(document).on("click", "#btnguardar", function () {
  // Validaciones campos vacíos
  var categoria = $("#categoria").val();
  var venta_id = $("#venta_id").val();
  var clie_id = $("#cliente_id").val();
  var clie_direccion = $("#cli_direccion").val();
  var clie_telefono = $("#cli_telefono").val();
  var comentario = $("#comentario").val();

  // Validación de campos vacíos
  if ($.trim(clie_id) === "" || $.trim(categoria) === "") {
    Swal.fire({
      title: "Error",
      text: "Todos los campos son obligatorios.",
      icon: "warning",
    });
  } else {
    // Verificar si hay productos agregados (total > 0)
    $.post(
      "../../controller/ctrVenta.php?op=calculo",
      { venta_id: venta_id },
      function (data) {
        data = JSON.parse(data);

        if (data.venta_total == null) {
          Swal.fire({
            title: "Error",
            text: "No hay productos agregados a la venta.",
            icon: "warning",
          });
          return;
        } else {
          // Guarda la venta
          $.post(
            "../../controller/ctrVenta.php?op=guardarVenta",
            {
              venta_id: venta_id,
              clie_id: clie_id,
              clie_direccion: clie_direccion,
              clie_telefono: clie_telefono,
              comentario: comentario,
            },
            function (data) {
              Swal.fire({
                title: "Venta",
                text: "Venta registrada correctamente con No. V-" + venta_id,
                icon: "success",
                footer: "<a href='../../view/ViewVenta/?v=" + venta_id + "' target='_blank'>Desea ver el Documento?</a>",
              }).then(() => {
                location.reload(); // Recargar la página
              });
            }
          );
        }
      }
    );
  }
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

// Trae datos de producto (Cuando cambie el producto, carga sus datos)
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
        precioventa.val(response["precioventa"]);
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
    $("#precio_venta").val("");
  }
});

// Trae datos de cliente
$(cliente).on("change", function () {
  $.ajax({
    url: "../../controller/ctrCliente.php?op=mostrar",
    type: "POST",
    data: { token: cliente.val() },
    dataType: "json",
    success: function (response) {
      direccion.val(response["direccion"]);
      telefono.val(response["telefono"]);
    },
    error: function (xhr, status, error) {
      console.error("Error en la petición AJAX:", error);
      Swal.fire("Error", "Ocurrió un error al procesar la solicitud.", "error");
    },
  });
});
