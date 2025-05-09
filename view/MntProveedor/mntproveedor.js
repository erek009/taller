let razonsocial = $("#razonsocial");
let razonhelp = $("#razonsocialhelper");
let rfc = $("#rfc");
let rfchelp = $("#rfchelper");
let telefono = $("#telefono");
let telefonohelp = $("#telefonohelper");
let email = $("#email");
let emailhelp = $("#emailhelper");

let token = $("#token");

function init() {
  $("#mantenimiento_form").on("submit", function (e) {
    guardaryeditar(e);
  });
}

function guardaryeditar(e) {
  e.preventDefault();
  var formData = new FormData($("#mantenimiento_form")[0]);

  // Validaciones
//   let isValidAno = ValidarAno(ano, anohelper); //
//   let formIsValid = isValidAno; //

//   if (formIsValid) {
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
// }

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
  telefono.val("");
  email.val("");
  token.val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();
