//nuevo usuario
let rol_nombre = $("#rol_nombre");
let rolhelper = $("#rolhelp");
let token = $("#token");

/* VALIDACIONES REGISTRO */
rol_nombre.on("keyup change blur", (e) => {
  ValidarRol(rol_nombre, rolhelper);
}); //

function init() {
  $("#mantenimiento_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}

function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#mantenimiento_form")[0]);
  formData.append("rol_nombre", rol_nombre.val());//

  // Validaciones
  let isValidRol = ValidarRol(rol_nombre, rolhelper); //
  let formIsValid = isValidRol; //

  if (formIsValid) {//

    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrRol.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "error-rolexiste") {
          // Si el año ya existe en la base de datos, mostrar un mensaje de error
          swal.fire({
            title: "Error",
            text: "El rol ya existe en el sistema.",
            icon: "error",
          });
        } else {
          $("#table_data").DataTable().ajax.reload();
          $("#modalmantenimiento").modal("hide");
          /* TODO: Mensaje de sweetalert */
          swal.fire({
            title: "Año",
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
      url: "../../controller/ctrRol.php?op=listar",
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
        url: "../../controller/ctrRol.php?op=eliminar",
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


//MENU **********************
function permiso(token) {
    
  //inserta menu segun rol
 $.post(
   "../../controller/ctrMenu.php?op=insert",{ token: token },function (data) {
     data = JSON.parse(data);
   }
 );
  $("#permisos_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    buttons: ["copyHtml5", "excelHtml5", "csvHtml5"],
    ajax: {
      url: "../../controller/ctrMenu.php?op=listar",
      type: "post",
      data: { token: token },
    },
    bDestroy: true,
    responsive: true,
    bInfo: true,
    iDisplayLength: 15,
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

 $("#modalpermiso").modal("show");
}

function habilitar(detalle_id) {
  $.post(
    "../../controller/ctrMenu.php?op=habilitar",
    { detalle_id: detalle_id },
    function (data) {
      $('#permisos_data').DataTable().ajax.reload();
    });
}

function deshabilitar(detalle_id) {
  $.post(
    "../../controller/ctrMenu.php?op=deshabilitar",
    { detalle_id: detalle_id },
    function (data) {
      $('#permisos_data').DataTable().ajax.reload();
    });
}
//MENU **********************

function editar(partoken) {
  $.post(
    "../../controller/ctrRol.php?op=mostrar",
    { token: partoken },
    function (data) {
      data = JSON.parse(data);
      token.val(data.token);
      rol_nombre.val(data.rol_nombre);
    }
  );
  $("#lbltitulo").html("Editar Registro");
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}

$(document).on("click", "#btnnuevo", function () {
  /* TODO: Limpiar informacion */
  rol_nombre.val("");
  token.val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();

// VALIDACION Año
function ValidarRol(Control, Helper) {
  if (Control.val().trim() == ""){
    Helper.text("Rol usuario requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Rol usuario no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}


//FUNCIONES OCULTAN HELPERS / BORRA DATOS EN INPUT
function OcultarHelpers() {
  rolhelper.hide();
}

function LimpiarFormularios() {
  rol_nombre.val("");
}

// Borra helpers
$("#modalmantenimiento").on("hidden.bs.modal", function () {
  OcultarHelpers();
  LimpiarFormularios();
});
