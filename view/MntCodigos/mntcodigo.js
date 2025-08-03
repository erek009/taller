//nuevo REGISTRO
let refaccion = $("#refaccion");
let refaccionhelp = $("#refaccionhelp");

let codigo = $("#codigo");
let codigoshelp = $("#codigoshelp");

let token = $("#token");

refaccion.on("keyup change blur", (e) => {
  ValidarRefaccion(refaccion, refaccionhelp);
});

codigo.on("keyup change blur", (e) => {
  ValidarCodigo(codigo, codigoshelp);
});



function init() {
  $("#mantenimiento_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}


// Guarda y edita registros
function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#mantenimiento_form")[0]);

  // Validaciones
  let isValidRefaccion = ValidarRefaccion(refaccion, refaccionhelp);
  let formIsValid = isValidRefaccion;

  if (formIsValid) {
    $.ajax({
      url: "../../controller/ctrCodigo.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        try {
          const response = JSON.parse(data);
          let mensajes = [];

          if (response.guardados && response.guardados.length > 0) {
            mensajes.push(
              `<strong>${response.guardados.length} código(s) guardado(s):</strong><br>` +
              response.guardados.join("<br>")
            );
            $("#table_data").DataTable().ajax.reload();
            $("#modalmantenimiento").modal("hide");
          }

          if (response.repetidos && response.repetidos.length > 0) {
            mensajes.push(
              `<strong>${response.repetidos.length} código(s) ya existen:</strong><br>` +
              response.repetidos.join("<br>")
            );

            // Si no se guardó ninguno, igual cerramos el modal
            if (!response.guardados || response.guardados.length === 0) {
              $("#modalmantenimiento").modal("hide");
            }
          }

          if (mensajes.length > 0) {
            swal.fire({
              icon: response.repetidos.length > 0 ? "warning" : "success",
              title: "Resultado del registro",
              html: mensajes.join("<hr>"),
              width: "600px",
            });
          }
        } catch (err) {
          console.error("Error al procesar la respuesta:", data);
          swal.fire({
            title: "Error",
            text: "Ocurrió un problema al guardar los códigos.",
            icon: "error",
          });
        }
      },
      error: function () {
        swal.fire({
          title: "Error",
          text: "No se pudo conectar con el servidor.",
          icon: "error",
        });
      },
    });
  }
}




$(document).ready(function () {
    $('#refaccion').select2({
        dropdownParent: $('#modalmantenimiento'), // <- Esta línea es clave
        placeholder: 'Seleccione refacción',
        width: '10%',
        allowClear: true
    });
});


//lista los datos en el datatable
$(document).ready(function () {
  /* TODO: Listar informacion en el datatable js */
  $("#table_data").DataTable({
    aProcessing: true,
    aServerSide: true,
    dom: "Bfrtip",
    buttons: ["copyHtml5", "excelHtml5", "csvHtml5"],
    ajax: {
      url: "../../controller/ctrCodigo.php?op=listar",
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


// Edita un registro
function editar(partoken) {
  $.post(
    "../../controller/ctrCodigo.php?op=mostrar",
    { token: partoken },
    function (data) {
      data = JSON.parse(data);

      // Cargar los valores en el formulario
      token.val(data.token);
      codigo.val(data.codigo);
      refaccion.val(data.refaccion);

      // ⚠️ Cargar valor en select2 (asegúrate que ya esté inicializado)
      // Esperar a que el DOM y select2 estén listos
      setTimeout(() => {
        refaccion.val(data.refaccion).trigger("change");
      }, 200); // Delay opcional para asegurar carga del select

      // Cambiar título del modal
      $("#lbltitulo").html("Editar Registro");

      // Mostrar modal
      $("#modalmantenimiento").modal("show");
    }
  );
}

$(document).on("click", "#btnnuevo", function () {
  // Limpiar campos
  codigo.val("");
  token.val("");

  // Limpiar Select2 correctamente
  refaccion.val(null).trigger("change");

  // Limpiar el formulario y título
  $("#mantenimiento_form")[0].reset();
  $("#lbltitulo").html("Nuevo Registro");

  // Mostrar modal
  $("#modalmantenimiento").modal("show");
});


init();



function ValidarRefaccion(Control, Helper) {
  let valor = (Control.val() || "").trim();

  if (valor === "") {
    Helper.text("El nombre de producto es requerido");
    Helper.show();
    return false;
  }

  if (!valor.match(/^[a-zA-Z0-9-ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("El nombre no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}



function ValidarCodigo(Control, Helper) {
  // if (Control.val().trim() == "") {
  //   Helper.text("El codigo de producto es requerido");
  //   Helper.show();
  //   return false;
  // }

  // if (!Control.val().match(/^[a-zA-Z0-9-ñÑáéíóúÁÉÍÓÚ ]+$/)) {
  //   Helper.text("Codigo no puede contener caracteres especiales");
  //   Helper.show();
  //   return false;
  // }

  // Helper.hide();
  // return true;
}


function OcultarHelpers() {
  refaccionhelp.hide();
  codigoshelp.hide();
}

function LimpiarFormularios() {
  refaccion.val("");
  codigo.val("");
}

// Borra helpers
$("#modalmantenimiento").on("hidden.bs.modal", function () {
  OcultarHelpers();
  LimpiarFormularios();
});
















