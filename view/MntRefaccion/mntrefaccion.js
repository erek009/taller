//nuevo REGISTRO
let codigo = $("#codigo");
let codigohelper = $("#codigohelp");

let nombre = $("#nombreproducto");
let nombrehelper = $("#nombrehelp");

let unidad = $("#unidadmedida");
let unidadhelper = $("#medidahelp");

let marca = $("#marca");
let marcahelper = $("#marcahelp");

let stock = $("#stock");
let stockhelper = $("#stockhelp");

let proveedor = $("#proveedor");
let proveedorhelper = $("#proveedorhelp");

let compra = $("#preciocompra");
let comprahelper = $("#comprahelp");

let venta = $("#precioventa");
let ventahelper = $("#ventahelp");

let descripcion = $("#descripcion");
let descripcionhelper = $("#descripcionhelp");

let token = $("#token");

/*VALIDACIONES REGISTRO*/
    codigo.on("keyup change blur", (e) => {
      ValidarCodigo(codigo, codigohelper);
    });
    
    nombre.on("keyup change blur", (e) => {
      ValidarNombre(nombre, nombrehelper);
    });
    
    unidad.on("keyup change blur", (e) => {
      ValidarUnidad(unidad, unidadhelper);
    });
    
    marca.on("keyup change blur", (e) => {
      ValidarMarca(marca, marcahelper);
    });
    
    stock.on("keyup change blur", (e) => {
      ValidarStock(stock, stockhelper);
    });
    
    proveedor.on("keyup change blur", (e) => {
      ValidarProveedor(proveedor, proveedorhelper);
    });
    
    compra.on("keyup change blur", (e) => {
      ValidarCompra(compra, comprahelper);
    });
    
    venta.on("keyup change blur", (e) => {
      ValidarVenta(venta, ventahelper);
    });
    
    descripcion.on("keyup change blur", (e) => {
      ValidarDescripcion(descripcion, descripcionhelper);
    });

function init() {
  $("#mantenimiento_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}

function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#mantenimiento_form")[0]);

   // Validaciones
   let isValidCodigo = ValidarCodigo(codigo, codigohelper);
   let isValidNombre = ValidarNombre(nombre, nombrehelper);
   let isValidUnidad = ValidarUnidad(unidad, unidadhelper);
   let isValidMarca = ValidarMarca(marca, marcahelper);
   let isValidStock = ValidarStock(stock, stockhelper);
   let isValidProveedor = ValidarProveedor(proveedor, proveedorhelper);
   let isValidCompra = ValidarCompra(compra, comprahelper);
   let isValidVenta = ValidarVenta(venta, ventahelper);
   let isValidDescripcion = ValidarDescripcion(descripcion, descripcionhelper);

   let formIsValid =
   isValidCodigo &&
   isValidNombre &&
   isValidUnidad &&
   isValidMarca &&
   isValidStock &&
   isValidProveedor &&
   isValidCompra &&
   isValidVenta &&
   isValidDescripcion;

  // formIsValid = true;
  if (formIsValid) {
    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrRefacciones.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "error-vehiculoexiste") {
          swal.fire({
            title: "Error",
            text: "La placa o VIN ya esta registrado.",
            icon: "error",
          });
        } else {
          $("#table_data").DataTable().ajax.reload();
          $("#modalmantenimiento").modal("hide");
          /* TODO: Mensaje de sweetalert */
          swal.fire({
            title: "Refaccion",
            text: "Registro Confirmado",
            icon: "success",
          });
        }
      },
    });
  }
}

$(document).ready(function () {
    /* TODO: Listar informacion en el datatable js */
    $("#table_data").DataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5"],
      ajax: {
        url: "../../controller/ctrRefacciones.php?op=listar",
        type: "post",
        data: { token : 1},
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
  });


  function eliminar(token) {
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
            "../../controller/ctrRefacciones.php?op=eliminar",
            { token: token },
            function (data) {
              console.log(data);
            }
          );
  
          $("#table_data").DataTable().ajax.reload();
  
          swal.fire({
            title: "Año vehiculo",
            text: "Registro Eliminado",
            icon: "success",
          });
        }
      });
  }

  function editar(token) {
    $.post(
      "../../controller/ctrRefacciones.php?op=mostrar",
      { token: token },
      function (data) {
        data = JSON.parse(data);
        $("#token").val(data.token);
        codigo.prop("disabled", true);
        codigo.val(data.codigo);
        nombre.val(data.nombre);
        unidad.val(data.unidadmedida);
        marca.val(data.marca);
        stock.prop("disabled", true);
        stock.val(data.stock);
        proveedor.val(data.proveedor);
        compra.val(data.preciocompra);
        venta.val(data.precioventa);
        descripcion.val(data.descripcion);
      }
    );
    $("#lbltitulo").html("Editar Registro");
    /* TODO: Mostrar Modal */
    $("#modalmantenimiento").modal("show");
  }

  $(document).on("click", "#btnnuevo", function () {
    codigo.prop("disabled", false);
    stock.prop("disabled", false);
    /* TODO: Limpiar informacion */
    codigo.val("");
    nombre.val("");
    unidad.val("");
    marca.val("");
    stock.val("");
    proveedor.val("");
    compra.val("");
    venta.val("");
    descripcion.val("");
    $("#token").val("");
    $("#lbltitulo").html("Nuevo Registro");
    $("#mantenimiento_form")[0].reset();
    /* TODO: Mostrar Modal */
    $("#modalmantenimiento").modal("show");
  });
  
  init();

  // VALIDACIONES //

function ValidarCodigo(Control, Helper) {
  if (Control.val().trim()== "") {
    Helper.text("El codigo de producto es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9-ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Codigo no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

function ValidarNombre(Control, Helper) {
  if (Control.val().trim()== "") {
    Helper.text("El nombre de producto es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9-ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("El nombre no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

function ValidarUnidad(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("Unidad requerido");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

function ValidarMarca(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("La marca del producto es requerida");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9-ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("La marca no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

function ValidarStock(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("Cantidad de stock requerida");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[0-9]+$/)) {
    Helper.text("Cantidad de producto invalida");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

function ValidarProveedor(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("El nombre del proveedor es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9-ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Proveedor no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

function ValidarCompra(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("El precio de compra es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[0-9]+/)) {
    Helper.text("Compra no puede contener numero menor a 0");
    Helper.show();
    return false;
  }
  Helper.hide();
  return true;
}

function ValidarVenta(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("El precio de venta es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[0-9]+/)) {
    Helper.text("Compra no puede contener numero menor a 0");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

function ValidarDescripcion(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("La descripcion del producto es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9-ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Descripcion no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}


//OCULTA MENSAJES HELPER
function OcultarHelpers() {
  codigohelper.hide();
  nombrehelper.hide();
  unidadhelper.hide();
  marcahelper.hide();
  stockhelper.hide();
  proveedorhelper.hide();
  comprahelper.hide();
  ventahelper.hide();
  descripcionhelper.hide();
}

//LIMPIA MENSAJES HELPER
function LimpiarFormularios() {
  codigo.val("");
  nombre.val("");
  unidad.val("");
  marca.val("");
  stock.val("");
  proveedor.val("");
  compra.val("");
  venta.val("");
  descripcion.val("");
}

// Borra helpers & limpiar formularios
$("#modalmantenimiento").on("hidden.bs.modal", function () {
  OcultarHelpers();
  LimpiarFormularios();
});
