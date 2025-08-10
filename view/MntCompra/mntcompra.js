var usu_id = $("#token_usu").val();

var proveedor = $("#prov_id");
var rfc = $("#prov_rfc");
var direccion = $("#prov_direccion");
var correo = $("#prov_email");
var telefono = $("#prov_telefono");

var categoria = $("#categoria");
var producto = $("#producto");

var producto1 = $("#producto1");
var stock = $("#stock");
var undmedida = $("#und_medida");
var anaquel = $("#anaquel");
var nivel = $("#nivel");
var preciocompra = $("#precio_compra");

// Inicializa el DataTable para mostrar los detalles de la compra
$(document).ready(function () {
  $.post(
    "../../controller/ctrCompra.php?op=registrar",
    { usu_id: usu_id },
    function (data) {
      data = JSON.parse(data);
      $("#compra_id").val(data.compra_id);
    }
  );
});


// Agrega un nuevo detalle de compra
$(document).on("click", "#btnagregar", function () {

  var refaccion = $("#producto_token").val();
  var compra_id = $("#compra_id").val();
  var preciocompra = $("#precio_compra").val();
  var unidadmedida = $("#und_medida").val();
  var cantidad = $("#detc_cant").val();

  // Validación de campos vacíos
  if (
    $("#refaccion").val() == "" ||
    $("#precio_compra").val() == "" ||
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
      "../../controller/ctrCompra.php?op=registrardetalleproductos",
      {
        refaccion: refaccion,
        compra_id: compra_id,
        unidadmedida: unidadmedida,
        preciocompra: preciocompra,
        cantidad: cantidad,
      },
      function (data) {
        console.log("Detalle registrado:", data);

        // Calcular subtotal/iva/total después de cada registro
        $.post(
          "../../controller/ctrCompra.php?op=calculo",
          { compra_id: compra_id },
          function (data) {
            data = JSON.parse(data);
            $("#precio_subtotal").html(data.compra_subtotal);
            $("#precio_iva").html(data.compra_iva);
            $("#precio_total").html(data.compra_total);
          }
        );

        // limpiar campos después de agregar el detalle
        $('#producto1').val("");
        $("#precio_compra").val("");
        $("#stock").val("");
        $("#und_medida").val("");
        $("#anaquel").val("");
        $("#nivel").val("");
        $("#producto_token").val("");
        $("#detc_cant").val("");

        // Actualizar listado
        listar(compra_id);
      }
    );
  }
});


//listado de productos
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

            // Recargar tabla
            $("#table_data").DataTable().ajax.reload();

            // confirmación de eliminación
            swal.fire({
              title: "Producto",
              text: "Registro Eliminado",
              icon: "success",
            });

            //Recalcular $$ totales
            var compra_id = $("#compra_id").val();
            $.post(
              "../../controller/ctrCompra.php?op=calculo",
              { compra_id: compra_id },
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


$(document).on("click", "#btnguardar", function () {
  // Validaciones campos vacíos
  var compra_id = $("#compra_id").val();
  var prov_id = $("#prov_id").val();
  var prov_rfc = $("#prov_rfc").val();
  var prov_direccion = $("#prov_direccion").val();
  var prov_email = $("#prov_email").val();
  var prov_telefono = $("#prov_telefono").val();
  var comentario = $("#comentario").val();

  // Validación de campos vacíos
  if ($.trim(prov_id) === "") {
    Swal.fire({
      title: "Error",
      text: "Todos los campos son obligatorios.",
      icon: "warning",
    });
  } else {
    // Verificar si hay productos agregados (total > 0)
    $.post(
      "../../controller/ctrCompra.php?op=calculo",
      { compra_id: compra_id },
      function (data) {
        data = JSON.parse(data);

        if (data.compra_total == null) {
          Swal.fire({
            title: "Error",
            text: "No hay productos agregados a la compra.",
            icon: "warning",
          });
          return;
        } else {
          // Guarda la compra
          $.post(
            "../../controller/ctrCompra.php?op=guardarCompra",
            {
              compra_id: compra_id,
              prov_id: prov_id,
              prov_rfc: prov_rfc,
              prov_direccion: prov_direccion,
              prov_email: prov_email,
              prov_telefono: prov_telefono,
              comentario: comentario,
            },
            function (data) {
              Swal.fire({
                title: "Compra",
                text: "Compra registrada correctamente con No. C-" + compra_id,
                icon: "success",
                footer: "<a href='../../view/ViewCompra/?c=" + compra_id + "' target='_blank'>Desea ver el Documento?</a>",
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


// Inicializar Select2 en el input de búsqueda
$("#busqueda_producto").select2({
  placeholder: "Buscar por nombre o código...",
  allowClear: true,
  ajax: {
    url: "../../controller/ctrCompra.php?op=buscar_producto",
    type: "POST",
    dataType: "json",
    delay: 250,
    data: function (params) {
      return {
        termino: params.term
      };
    },
    processResults: function (data) {
      if (!data) return { results: [] };

      return {
        results: data.map(function (producto) {
          return {
            id: producto.token,
            text: `${producto.nombre} (${producto.codigo})`,
            data: producto
          };
        })
      };
    },
    cache: true
  },
  minimumInputLength: 2
});

// Al seleccionar un producto del autocompletado
$("#busqueda_producto").on("select2:select", function (e) {
  const producto = e.params.data.data;

  $("#producto1").val(producto.nombre);
  $("#producto_token").val(producto.token);
  $("#stock").val(producto.stock);
  $("#und_medida").val(producto.unidadmedida);
  $("#anaquel").val(producto.anaquelNombre);
  $("#nivel").val(producto.nivelNombre);
  $("#precio_compra").val(producto.preciocompra);
});

// Opcional: limpiar campos si se limpia el select2
$("#busqueda_producto").on("select2:clear", function () {
  $("#producto1").val("");
  $("#producto_token").val("");
  $("#stock").val("");
  $("#und_medida").val("");
  $("#anaquel").val("");
  $("#nivel").val("");
  $("#precio_compra").val("");
});






