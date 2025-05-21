let servicio = $("#servicio");
let serviciohelper = $("#serviciohelp");
let costo = $("#costo");
let costohelper = $("#costohelp");
let descripcion = $("#descripcion");
let descripcionhelper = $("#descripcionhelp");

let token = $("#token");

/* VALIDACIONES */
servicio.on("keyup change blur", (e) => {
  ValidarServicio(servicio, serviciohelper);
});

costo.on("keyup change blur", (e) => {
  ValidarCosto(costo, costohelper);
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
  let isValidServicio = ValidarServicio(servicio, serviciohelper);
  let isValidCosto = ValidarCosto(costo, costohelper);
  let isValidDescripcion = ValidarDescripcion(descripcion, descripcionhelper);

  let formIsValid = isValidServicio && isValidCosto && isValidDescripcion;

  if (formIsValid) {
    //

    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrServicio.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "error-servicioexiste") {
          // Si el año ya existe en la base de datos, mostrar un mensaje de error
          swal.fire({
            title: "Error",
            text: "El servicio ya existe en el sistema.",
            icon: "error",
          });
        } else {
          $("#table_data").DataTable().ajax.reload();
          $("#modalmantenimiento").modal("hide");
          /* TODO: Mensaje de sweetalert */
          swal.fire({
            title: "Servicio",
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
      url: "../../controller/ctrServicio.php?op=listar",
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
    }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "../../controller/ctrServicio.php?op=eliminar",
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
    "../../controller/ctrServicio.php?op=mostrar",
    { token: partoken },
    function (data) {
      data = JSON.parse(data);
      token.val(data.token);
      servicio.val(data.nombreservicio);
      costo.val(data.costomobra);
      descripcion.val(data.descripcion);
    }
  );
  $("#lbltitulo").html("Editar Registro");
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}

$(document).on("click", "#btnnuevo", function () {
  /* TODO: Limpiar informacion */
  servicio.val("");
  costo.val("");
  descripcion.val("");
  token.val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();

// VALIDACIONES //

// valida servicio
function ValidarServicio(Control, Helper) {
  if (Control.val() == "" || Control.val().length <= 0) {
    Helper.text("Nombre del servicio requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9-ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Nombre servicio no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida costo
function ValidarCosto(Control, Helper) {
  if (Control.val() == "" || Control.val().length <= 0) {
    Helper.text("Costo del servicio requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[0-9 ]+$/)) {
    Helper.text("Descripcion no puede contener caracteres especiales");
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

function OcultarHelpers() {
  serviciohelper.hide();
  costohelper.hide();
  descripcionhelper.hide();
}

function LimpiarFormularios() {
  servicio.val("");
  costo.val("");
  descripcion.val("");
}

// Borra helpers
$("#modalmantenimiento").on("hidden.bs.modal", function () {
  OcultarHelpers();
  LimpiarFormularios();
});
