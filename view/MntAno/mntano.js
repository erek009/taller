//nuevo usuario
let ano = $("#AnoVehiculo");//
let anohelper = $("#anohelp");//

/* VALIDACIONES REGISTRO */
ano.on("keyup change blur", (e) => {//
  ValidarAno(ano, anohelper);//
});//

function init() {
  $("#mantenimiento_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}

function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#mantenimiento_form")[0]);

  // Validaciones
  let isValidAno = ValidarAno(ano, anohelper); //
  let formIsValid = isValidAno; //

  if (formIsValid) {//

    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrAnoVehiculo.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {

        
        if (data === "error-anoexiste") {
          // Mostrar el error si el año ya existe
          alert("El año del vehículo ya existe en el sistema.");
      } else {

        // console.log("llega");
        $("#table_data").DataTable().ajax.reload();
        $("#modalmantenimiento").modal("hide");
        /* TODO: Mensaje de sweetalert */
        swal.fire({
          title: "Año",
          text: "Registro Confirmado",
          icon: "success",
        });
      }
    }
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
      url: "../../controller/ctrAnoVehiculo.php?op=listar",
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
          "../../controller/ctrAnoVehiculo.php?op=eliminar",
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
    "../../controller/ctrAnoVehiculo.php?op=mostrar",
    { token: token },
    function (data) {
      data = JSON.parse(data);
      $("#token").val(data.token);
      $("#AnoVehiculo").val(data.ano);
    }
  );
  $("#lbltitulo").html("Editar Registro");
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}


$(document).on("click", "#btnnuevo", function () {
  /* TODO: Limpiar informacion */
  $("#AnoVehiculo").val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();

// VALIDACION Año

function ValidarAno(Control, Helper) {

  if (Control.val() === "") {
    Helper.text("El año es requerido");
    Helper.show();
    return false;
  }

  if (Control.val() < 1940 || Control.val() > 2040) {
    Helper.text("El año es invalido");
    Helper.show();
    return false;
  }

  if (Control.val().length < 4 || Control.val().length > 4) {
    Helper.text("El año del vehiculo es incorrecto");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[0-9]+$/)) {
    Helper.text("Direccion no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}
