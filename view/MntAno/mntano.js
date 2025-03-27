// console.log("test");

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
  