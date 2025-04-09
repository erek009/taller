//nuevo REGISTRO
let nombre = $("#nombre");
let nombrehelper = $("#nombrehelp");
let direccion = $("#direccion");
let direccionhelper = $("#direccionhelp");
let telefono = $("#telefono");
let telefonohelper = $("#telefonohelp");
let localidad = $("#localidad");
let localidadhelper = $("#localidadhelp");
let observaciones = $("#observaciones");
let observacionhelper = $("#observacioneshelp");

/*    VALIDACIONES     */
nombre.on("keyup change blur", (e) => {
  ValidarNombre(nombre, nombrehelper);
});

direccion.on("keyup change blur", (e) => {
  ValidarDireccion(direccion, direccionhelper);
});

telefono.on("keyup change blur", (e) => {
  ValidarTelefono(telefono, telefonohelper);
});

localidad.on("keyup change blur", (e) => {
  ValidarLocalidad(localidad, localidadhelper);
});

observaciones.on("keyup change blur", (e) => {
  ValidarObservacion(observaciones, observacionhelper);
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
  let isValidNombre = ValidarNombre(nombre, nombrehelper);
  let isValidDireccion = ValidarDireccion(direccion, direccionhelper);
  let isValidTelefono = ValidarTelefono(telefono, telefonohelper);
  let isValidLocalidad = ValidarLocalidad(localidad, localidadhelper);
  let isValidObservacion = ValidarObservacion(observaciones, observacionhelper);

  let formIsValid =
    isValidNombre &&
    isValidDireccion &&
    isValidTelefono &&
    isValidLocalidad &&
    isValidObservacion;

  if (formIsValid) {

    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrCliente.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "error-clienteexiste") {
          // Si el año ya existe en la base de datos, mostrar un mensaje de error
          swal.fire({
            title: "Error",
            text: "El cliente ya existe en el sistema.",
            icon: "error",
          });
        } else {
          $("#table_data").DataTable().ajax.reload();
          $("#modalmantenimiento").modal("hide");
          /* TODO: Mensaje de sweetalert */
          swal.fire({
            title: "Cliente",
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
      url: "../../controller/ctrCliente.php?op=listar",
      type: "post",
      data: { token: 1 },
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
          "../../controller/ctrCliente.php?op=eliminar",
          { token: token },
          function (data) {
            console.log(data);
          }
        );
        $("#table_data").DataTable().ajax.reload();
        swal.fire({
          title: "Cliente",
          text: "Registro Eliminado",
          icon: "success",
        });
      }
    });
}

function editar(token) {
  $.post(
    "../../controller/ctrCliente.php?op=mostrar",
    { token: token },
    function (data) {
      data = JSON.parse(data);
      $("#token").val(data.token);
      $("#nombre").val(data.nombre);
      $("#direccion").val(data.direccion);
      $("#telefono").val(data.telefono);
      $("#localidad").val(data.localidad);
      $("#observaciones").val(data.observaciones);
    }
  );
  $("#lbltitulo").html("Editar Registro");
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}

$(document).on("click", "#btnnuevo", function () {
  /* TODO: Limpiar informacion */
  $("#nombre").val("");
  $("#direccion").val("");
  $("#telefono").val("");
  $("#localidad").val("");
  $("#observaciones").val("");
  $("#token").val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();

// VALIDACIONES //
// valida nombre
function ValidarNombre(Control, Helper) {
  if (Control.val().trim() == ""){
    Helper.text("El Nombre requerido");
    Helper.show();
    return false;
  }

  if (Control.val().length < 10 || Control.val().length > 30) {
    Helper.text("Minimo 10 caracteres. Max 30");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Nombre no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida DIRECCION
function ValidarDireccion(Control, Helper) {
  // Verificar si el campo está vacío o contiene solo espacios
  if (Control.val().trim() == "") {
    Helper.text("La dirección es requerida");
    Helper.show();
    return false;
  }

  // Verificar si la dirección contiene caracteres no permitidos
  if (!Control.val().match(/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("La dirección no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida TELEFONO
function ValidarTelefono(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("Numero de telefono es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[0-9]+$/)) {
    Helper.text("El telefono solo debe contener numeros");
    Helper.show();
    return;
  }

  if (Control.val().length < 10 || Control.val().length > 10) {
    Helper.text("El telefono debe ser de 10 digitos");
    Helper.show();
    return false;
  }
  Helper.hide();
  return true;
}

// valida LOCALIDAD
function ValidarLocalidad(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("La direccion es requerida");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Localidad no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida OBSERVACIONES
function ValidarObservacion(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("Descripcion requerida");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Observaciones no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

function OcultarHelpers() {
  nombrehelper.hide();
  direccionhelper.hide();
  telefonohelper.hide();
  observacionhelper.hide();
}

function LimpiarFormularios() {
  nombre.val("");
  direccion.val("");
  telefono.val("");
  observaciones.val("");
}

// Borra helpers
$("#modalmantenimiento").on("hidden.bs.modal", function () {
  OcultarHelpers();
  LimpiarFormularios();
});
