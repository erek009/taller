let razonsocial = $("#razonsocial");
let razonhelp = $("#razonsocialhelper");
let rfc = $("#rfc");
let rfchelp = $("#rfchelper");
let direccion = $("#direccion");
let direchelp = $("#direccionhelper");
let telefono = $("#telefono");
let telefonohelp = $("#telefonohelper");
let email = $("#email");
let emailhelp = $("#emailhelper");

let token = $("#token");

// Manda validar razonsocial
razonsocial.on("keyup change blur", (e) => {
  ValidarRazonSocial(razonsocial, razonhelp);
});

rfc.on("keyup change blur", (e) => {
  ValidarRFC(rfc, rfchelp);
});

direccion.on("keyup change blur", (e) => {
  ValidarDireccion(direccion, direchelp);
});

telefono.on("keyup change blur", (e) => {
  ValidarTelefono(telefono, telefonohelp);
});

email.on("keyup change blur", (e) => {
  ValidarEmail(email, emailhelp);
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
  let isValidRsocial = ValidarRazonSocial(razonsocial, razonhelp); //
  let isValidRfc = ValidarRFC(rfc, rfchelp);
  let isValidDireccion = ValidarDireccion(direccion, direchelp);
  let isTelefono = ValidarTelefono(telefono, telefonohelp);
  let isEmail = ValidarEmail(email, emailhelp);

  let formIsValid = isValidRsocial && isValidRfc &&isValidDireccion && isTelefono && isEmail;

  if (formIsValid) {
    //

    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrProveedor.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "error-proveedorexiste") {
          // Si el año ya existe en la base de datos, mostrar un mensaje de error
          swal.fire({
            title: "Error",
            text: "El proveedor ya esta registrado en el sistema.",
            icon: "error",
          });
        } else {
          $("#table_data").DataTable().ajax.reload();
          $("#modalmantenimiento").modal("hide");
          /* TODO: Mensaje de sweetalert */
          swal.fire({
            title: "Proveedor",
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
      url: "../../controller/ctrProveedor.php?op=listar",
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
          "../../controller/ctrProveedor.php?op=eliminar",
          { token: token },
          function (data) {
            console.log(data);
          }
        );

        $("#table_data").DataTable().ajax.reload();

        swal.fire({
          title: "Proveedor",
          text: "Registro Eliminado",
          icon: "success",
        });
      }
    });
}

function editar(partoken) {
  $.post(
    "../../controller/ctrProveedor.php?op=mostrar",
    { token: partoken },
    function (data) {
      data = JSON.parse(data);
      token.val(data.token);
      razonsocial.val(data.razonsocial);
      rfc.val(data.rfc);
      direccion.val(data.direccion);
      telefono.val(data.telefono);
      email.val(data.email);
    }
  );
  $("#lbltitulo").html("Editar Registro");
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}

$(document).on("click", "#btnnuevo", function () {
  /* TODO: Limpiar informacion */
  razonsocial.val("");
  rfc.val("");
  direccion.val("");
  telefono.val("");
  email.val("");
  token.val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();

// valida razonsocial
function ValidarRazonSocial(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("El Nombre requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Nombre no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida RFC
function ValidarRFC(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("El RFC requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/)) {
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

// valida email
function ValidarEmail(Control, Helper) {
  if (Control.val().trim() == "") {
    Helper.text("El correo es requerido");
    Helper.show();
    return false;
  }

  if (
    !Control.val().match(
      /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
    )
  ) {
    Helper.text("El correo debe contener correo@correo.com");
    Helper.show();
    return false;
  }
  Helper.hide();
  return true;
}

function OcultarHelpers() {
  razonhelp.hide();
  rfchelp.hide();
  telefonohelp.hide();
  emailhelp.hide();
}

function LimpiarFormularios() {
  razonsocial.val("");
  rfc.val("");
  telefono.val("");
  email.val("");
}

// Borra helpers
$("#modalmantenimiento").on("hidden.bs.modal", function () {
  OcultarHelpers();
  LimpiarFormularios();
});

