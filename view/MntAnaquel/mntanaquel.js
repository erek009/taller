//nuevo anaquel
let anaquel = $("#anaquel");
let anaquelhelper = $("#anaquelhelp");
let descripcion = $("#descripcion");
let descripcionhelper = $("#descripcionhelp");
let token = $("#token");

/* VALIDACIONES REGISTRO */
anaquel.on("keyup change blur", (e) => {
  ValidarAnaquel(anaquel, anaquelhelper);
}); 

descripcion.on("keyup change blur", (e) => {
  ValidarDescripcion(descripcion, descripcionhelper);
}); 


function init() {
  $("#mantenimiento_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}

// Función para guardar o editar el anaquel
function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#mantenimiento_form")[0]);

  // Validaciones
  let isValidAnaquel = ValidarAnaquel(anaquel, anaquelhelper);
  let isValidDescripcion = ValidarDescripcion(descripcion, descripcionhelper);

  let formIsValid = isValidAnaquel && isValidDescripcion;

  if (formIsValid) {
    //

    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrAnaquel.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "error-anaquelexiste") {
          // Si el año ya existe en la base de datos, mostrar un mensaje de error
          swal.fire({
            title: "Error",
            text: "El anaquel ya existe en el sistema.",
            icon: "error",
          });
        } else {
          $("#table_data").DataTable().ajax.reload();
          $("#modalmantenimiento").modal("hide");
          /* TODO: Mensaje de sweetalert */
          swal.fire({
            title: "Anaquel",
            text: "Registro Confirmado",
            icon: "success",
          });
        }
      },
    });
  }
}


// Listar informacion en el datatable js
$(document).ready(function () {
  /* TODO: Listar informacion en el datatable js */
  $("#table_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    buttons: ["copyHtml5", "excelHtml5", "csvHtml5"],
    ajax: {
      url: "../../controller/ctrAnaquel.php?op=listar",
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

// Función para eliminar un anaquel
function eliminar(token) {
  swal
    .fire({
      title: "Eliminar!",
      text: "Desea Eliminar el Registro?",
      icon: "error",
      confirmButtonText: "Si",
      showCancelButton: true,
      cancelButtonText: "No",
    }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../controller/ctrAnaquel.php?op=eliminar",
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

// Función para editar un anaquel
function editar(partoken) {
  $.post(
    "../../controller/ctrAnaquel.php?op=mostrar",
    { token: partoken },
    function (data) {
      data = JSON.parse(data);
      token.val(data.token);
      anaquel.val(data.anaquel);
      descripcion.val(data.descripcion);
    }
  );
  $("#lbltitulo").html("Editar Registro");
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}

//BOTON Nuevo registro de anaquel
$(document).on("click", "#btnnuevo", function () {
  /* TODO: Limpiar informacion */
  anaquel.val("");
  descripcion.val("");
  token.val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();


// VALIDACION Categoria
function ValidarAnaquel(Control, Helper) {
  if (Control.val().trim() == ""){
    Helper.text("Inicial de anaquel requerido");
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


// valida descripcion
function ValidarDescripcion(Control, Helper) {
  if (Control.val() == "" || Control.val().length <= 0) {
    Helper.text("Descripcion requerida");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Descripcion no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}


// Oculta helpers
function OcultarHelpers() {
  anaquelhelper.hide();
  descripcionhelper.hide();
}
// Limpia los formularios
function LimpiarFormularios() {
  anaquel.val("");
  descripcion.val("");
}

// Borra helpers
$("#modalmantenimiento").on("hidden.bs.modal", function () {
  OcultarHelpers();
  LimpiarFormularios();
});
