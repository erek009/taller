let nombre = $("#nombre");
let nombrehelper = $("#nombrehelp");
let correo = $("#correo");
let correohelper = $("#correohelp");
let password = $("#password");
let passhelper = $("#passhelp");
let confirmpass = $("#confirmpass");
let confirmpasshelper = $("#confirmpasshelp");
let token = $("#token");

// Manda validar nombre
nombre.on("keyup change blur", (e) => {
  ValidarName(nombre, nombrehelper);
});

// Manda validar  marca
correo.on("keyup change blur", (e) => {
  ValidarEmail(correo, correohelper);
});

// manda a validar password
password.on("keyup change blur", (e) => {
  ValidarPass(password, passhelper);
});

//confirma contra
confirmpass.on("keyup change blur", (e) => {
  ValidarConfirmpass(confirmpass, password, confirmpasshelper);
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
  let isValidNombre = ValidarName(nombre, nombrehelper);
  let isValidEmail = ValidarEmail(correo, correohelper);
  // let isValidarPass = ValidarPass(password, passhelper);
  // let isValidarConfirmpass = ValidarConfirmpass(
  //  confirmpass,
  //  password,
  //  confirmpasshelper
  // );

  let isValidarPass;
  let isValidarConfirmpass;

  // Solo validar la contraseña si el token está vacío
  if (token.val() == "") {
    isValidarPass = ValidarPass(password, passhelper);
    isValidarConfirmpass = ValidarConfirmpass(
      confirmpass,
      password,
      confirmpasshelper
    );
  } else {
    if (password.val() != "") {
      isValidarPass = ValidarPass(password, passhelper);
      isValidarConfirmpass = ValidarConfirmpass(
        confirmpass,
        password,
        confirmpasshelper
      );
    } else {
      isValidarPass = true;
      isValidarConfirmpass = true;
    }
  }

  let formIsValid =
    isValidNombre && isValidEmail && isValidarPass && isValidarConfirmpass;

  if (formIsValid) {
    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrUsuario.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "error-nombreexiste") {
          swal.fire({
            title: "Error",
            text: "El nombre de usuario ya está registrado.",
            icon: "error",
          });
        } else if (data === "error-correoexiste") {
          swal.fire({
            title: "Error",
            text: "El correo electrónico ya está registrado.",
            icon: "error",
          });
        } else {
          $("#table_data").DataTable().ajax.reload();
          $("#modalmantenimiento").modal("hide");
          /* TODO: Mensaje de sweetalert */
          swal.fire({
            title: "Usuario",
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
      url: "../../controller/ctrUsuario.php?op=listar",
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
  Swal.fire({
    title: "Eliminar!",
    text: "¿Desea eliminar el registro?",
    icon: "warning",
    confirmButtonText: "Sí",
    showCancelButton: true,
    cancelButtonText: "No",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../controller/ctrUsuario.php?op=eliminar",
        type: "POST",
        data: { token: token },
        dataType: "json",
        success: function (response) {
          if (response.status === "error") {
            Swal.fire("Atención", response.message, "warning");
          } else if (response.status === "ok") {
            Swal.fire("Eliminado", response.message, "success").then(() => {
              $("#table_data").DataTable().ajax.reload();
            });
          }
        },
        error: function (xhr, status, error) {
          console.error("Error en la petición AJAX:", error);
          Swal.fire("Error", "Ocurrió un error al procesar la solicitud.", "error");
        }
      });
    }
  });
}


function editar(partoken) {
  $.post(
    "../../controller/ctrUsuario.php?op=mostrar",
    { token: partoken },
    function (data) {
      data = JSON.parse(data);
      token.val(data.token);
      nombre.val(data.nombre);
      correo.val(data.correo);
      password.val(data.password);
    }
  );
  $("#lbltitulo").html("Editar Registro");
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}

$(document).on("click", "#btnnuevo", function () {
  /* TODO: Limpiar informacion */
  nombre.val("");
  correo.val("");
  password.val("");
  confirmpass.val("");
  token.val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();

// valida nombre
function ValidarName(Control, Helper) {
  if (Control.val() == "" || Control.val().length <= 0) {
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

// valida email
function ValidarEmail(Control, Helper) {
  if (Control.val() == "") {
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

// valida password
function ValidarPass(Control, Helper) {
  if (Control.val() == "") {
    Helper.text("La contraseña es requerida");
    Helper.show();
    return false;
  }

  if (
    !Control.val().match(
      /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,15}/
    )
  ) {
    Helper.text("Min. 8 caracteres, 1 mayuscula, 1 digito, 1 caract especial.");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// NUEVA valida password
function ValidarConfirmpass(Control, Control1, Helper) {
  if (Control.val() == "") {
    Helper.text("La confirmacion es requerida");
    Helper.show();
    return false;
  }

  if (Control.val() != Control1.val()) {
    Helper.text("La contraseña es diferente");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

function OcultarHelpers() {
  nombrehelper.hide();
  correohelper.hide();
  passhelper.hide();
  confirmpasshelper.hide();
}

function LimpiarFormularios() {
  nombre.val("");
  correo.val("");
  password.val("");
  confirmpass.val("");
}

// Borra helpers
$("#modalmantenimiento").on("hidden.bs.modal", function () {
  OcultarHelpers();
  LimpiarFormularios();
});
