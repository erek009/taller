let vehiculo = $("#vehiculo");
let vehiculohelp = $("#vehiculohelper");
let concepto = $("#concepto");
let conceptohelp = $("#conceptohelper");
let combustible = $("#combustible");
let combustiblehelp = $("#combustiblehelper");
let kilometros = $("#kilometros");
let kilometroshelp = $("#kilometroshelper");
let tecnico = $("#tecnico");
let tecnicohelp = $("#tecnicohelper");
let servicio = $("#servicio");
let serviciohelp = $("#serviciohelper");

let token = $("#token");

/*
    VALIDACIONES REGISTRO
    */
vehiculo.on("keyup change blur", (e) => {
  ValidarVehiculo(vehiculo, vehiculohelp);
});

concepto.on("keyup change blur", (e) => {
  ValidarConcepto(concepto, conceptohelp);
});

combustible.on("keyup change blur", (e) => {
  ValidarCombustible(combustible, combustiblehelp);
});

kilometros.on("keyup change blur", (e) => {
  ValidarKilometros(kilometros, kilometroshelp);
});

tecnico.on("keyup change blur", (e) => {
  ValidarTecnico(tecnico, tecnicohelp);
});

servicio.on("keyup change blur", (e) => {
  ValidarServicio(servicio, serviciohelp);
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
  let isValidVehiculo = ValidarVehiculo(vehiculo, vehiculohelp);
  let isValidConcepto = ValidarConcepto(concepto, conceptohelp);
  let isValidCombustible = ValidarCombustible(combustible, combustiblehelp);
  let isValidKilometros = ValidarKilometros(kilometros, kilometroshelp);
  let isValidTecnico = ValidarTecnico(tecnico, tecnicohelp);
  let isValidServicio = ValidarServicio(servicio, serviciohelp);

  let formIsValid =
    isValidVehiculo &&
    isValidConcepto &&
    isValidCombustible &&
    isValidKilometros &&
    isValidTecnico &&
    isValidServicio;

  if (formIsValid) {
    //

    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrOrden.php?op=guardaryeditar",
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
            title: "Orden",
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
      url: "../../controller/ctrOrden.php?op=listar",
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
          "../../controller/ctrOrden.php?op=eliminar",
          { token: token },
          function (data) {
            console.log(data);

        $("#table_data").DataTable().ajax.reload();

        swal.fire({
          title: "Orden",
          text: "Registro Eliminado",
          icon: "success",
         });
          }
        );
      }
    });
}

function editar(partoken) {
  $.post(
    "../../controller/ctrOrden.php?op=mostrar",
    { token: partoken },
    function (data) {
      data = JSON.parse(data);
      token.val(data.token);
      vehiculo.val(data.idvehiculo);
      concepto.val(data.concepto);
      combustible.val(data.nivelcombustible);
      kilometros.val(data.kilometros);
      tecnico.val(data.idusuario);
      servicio.val(data.idservicio);
    }
  );
  $("#lbltitulo").html("Editar Registro");
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}

$(document).on("click", "#btnnuevo", function () {
  /* TODO: Limpiar informacion */
  servicio.val("");
  vehiculo.val("");
  concepto.val("");
  combustible.val("");
  kilometros.val("");
  tecnico.val("");
  servicio.val("");
  token.val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();

// VALIDACIONES //

// valida vehiculo
function ValidarVehiculo(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("Seleccione un vehiculo");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida concepto
function ValidarConcepto(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("Seleccione un concepto");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida combustible
function ValidarCombustible(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("Nivel de combustible requerido");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida kilometros
function ValidarKilometros(Control, Helper) {
  if (Control.val() == "" || Control.val().length <= 0) {
    Helper.text("Kilometraje total requerido");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida Tecnico
function ValidarTecnico(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("Tecnico requerido");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida Servicio
function ValidarServicio(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("Seleccione un tipo de servicio");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}


function OcultarHelpers() {
  vehiculohelp.hide();
  conceptohelp.hide();
  combustiblehelp.hide();
  kilometroshelp.hide();
  tecnicohelp.hide();
  serviciohelp.hide();
}

function LimpiarFormularios() {
  vehiculo.val("");
  concepto.val("");
  combustiblehelp.val("");
  kilometros.val("");
  tecnico.val("");
  servicio.val("");
}

// Borra helpers
$("#modalmantenimiento").on("hidden.bs.modal", function () {
  OcultarHelpers();
  LimpiarFormularios();
});
