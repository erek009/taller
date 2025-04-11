
function init() {
  $("#mantenimiento_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}

function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#mantenimiento_form")[0]);

  // Validaciones
  // let isValidServicio = ValidarServicio(servicio, serviciohelper);
  // let isValidCosto = ValidarCosto(costo, costohelper);
  // let isValidDescripcion = ValidarDescripcion(descripcion, descripcionhelper);

  // let formIsValid = isValidServicio && isValidCosto && isValidDescripcion;

  // if (formIsValid) {
    //

    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrVehiculo.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "error-servicioexiste") {
          // Si el año ya existe en la base de datos, mostrar un mensaje de error
          swal.fire({
            title: "Error",
            text: "El vehiculo ya existe en el sistema.",
            icon: "error",
          });
        } else {
          $("#table_data").DataTable().ajax.reload();
          $("#modalmantenimiento").modal("hide");
          /* TODO: Mensaje de sweetalert */
          swal.fire({
            title: "Vehiculo",
            text: "Registro Confirmado",
            icon: "success",
          });
        }
      },
    });
  }
//}
$(document).ready(function () {
    /* TODO: Listar informacion en el datatable js */
    $("#table_data").DataTable({
      aProcessing: true,
      aServerSide: true,
      dom: "Bfrtip",
      buttons: ["copyHtml5", "excelHtml5", "csvHtml5"],
      ajax: {
        url: "../../controller/ctrVehiculo.php?op=listar",
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
            "../../controller/ctrVehiculo.php?op=eliminar",
            { token: token },
            function (data) {
              console.log(data);
            }
          );
  
          $("#table_data").DataTable().ajax.reload();
  
          swal.fire({
            title: "Vehiculo",
            text: "Registro Eliminado",
            icon: "success",
          });
        }
      });
  }
  
  function editar(token) {
    $.post(
      "../../controller/ctrVehiculo.php?op=mostrar",
      { token: token },
      function (data) {
        data = JSON.parse(data);
        $("#token").val(data.token);
        $("#tipo").val(data.tipo);
        $("#placa").val(data.placa);
        $("#marca").val(data.idmarca);
        $("#modelo").val(data.model);
        $("#ano").val(data.idano);
        $("#vin").val(data.vin);
        $("#color").val(data.color);
        $("#cliente").val(data.idcliente);
      }
    );
    $("#lbltitulo").html("Editar Registro");
    /* TODO: Mostrar Modal */
    $("#modalmantenimiento").modal("show");
  }
  
  $(document).on("click", "#btnnuevo", function () {
    /* TODO: Limpiar informacion */
    $("#tipo").val("");
    $("#placa").val("");
    $("#idmarca").val("");
    $("#model").val("");
    $("#idano").val("");
    $("#vin").val("");
    $("#color").val("");
    $("#idcliente").val("");
    $("#token").val("");
    $("#lbltitulo").html("Nuevo Registro");
    $("#mantenimiento_form")[0].reset();
    /* TODO: Mostrar Modal */
    $("#modalmantenimiento").modal("show");
  });
  
  init();