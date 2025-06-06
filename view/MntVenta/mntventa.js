// Variables cliente
var cliente = $("#cliente_id");
var direccion = $("#cli_direccion");
var telefono = $("#cli_telefono");

//variables productos
var categoria = $("#categoria");
var producto = $("#producto");
var stock = $("#stock");
var undmedida = $("#und_medida");
var preciocompra = $("#precio_compra");

$(document).ready(function () {

    
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
