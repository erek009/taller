//nuevo REGISTRO
let tipo = $("#tipo");
let tipohelper = $("#tipohelp");

let placa = $("#placa");
let placahelper = $("#placahelp");

let marca = $("#marca");
let marcahelper = $("#marcahelp");

let modelo = $("#modelo");
let modelohelper = $("#modeloHelper");

let ano = $("#ano");
let anohelper = $("#anohelp");

let vin = $("#vin");
let vinhelper = $("#vinhelp");

let color = $("#color");
let colorhelper = $("#colorhelp");

let cliente = $("#cliente");
let clientehelp = $("#clientehelp");

let token = $("#token");

/* VALIDACIONES REGISTRO    */
tipo.on("keyup change blur", (e) => {
  ValidarTipo(tipo, tipohelper);
});

placa.on("keyup change blur", (e) => {
  ValidarPlaca(placa, placahelper);
});

marca.on("keyup change blur", (e) => {
  ValidarMarca(marca, marcahelper);
});

modelo.on("keyup change blur", (e) => {
  ValidarModelo(modelo, modelohelper);
});

ano.on("keyup change blur", (e) => {
  ValidarAno(ano, anohelper);
});

vin.on("keyup change blur", (e) => {
  ValidarVin(vin, vinhelper);
});

color.on("keyup change blur", (e) => {
  ValidarColor(color, colorhelper);
});

cliente.on("keyup change blur", (e) => {
  ValidarCliente(cliente, clientehelp);
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
  let isValidTipo = ValidarTipo(tipo, tipohelper);
  let isValidPlaca = ValidarPlaca(placa, placahelper);
  let isValidMarca = ValidarMarca(marca, marcahelper);
  let isValidModelo = ValidarModelo(modelo, modelohelper);
  let isValidAno = ValidarAno(ano, anohelper);
  let isValidVin = ValidarVin(vin, vinhelper);
  let isValidColor = ValidarColor(color, colorhelper);
  let isValidCliente = ValidarCliente(cliente, clientehelp);

  let formIsValid =
    isValidTipo &&
    isValidPlaca &&
    isValidMarca &&
    isValidAno &&
    isValidVin &&
    isValidColor &&
    isValidCliente &&
    isValidModelo;

  // formIsValid = true;
  if (formIsValid) {
    /* TODO: Guardar Informacion */
    $.ajax({
      url: "../../controller/ctrVehiculo.php?op=guardaryeditar",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data === "error-vehiculoexiste") {
          swal.fire({
            title: "Error",
            text: "La placa o VIN ya esta registrado.",
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
}

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

function editar(partoken) {
  $.post(
    "../../controller/ctrVehiculo.php?op=mostrar",
    { token: partoken },
    function (data) {
      data = JSON.parse(data);
      token.val(data.token);
      tipo.val(data.tipo);
      placa.val(data.placa);
      marca.val(data.idmarca);
      modelo.val(data.model);
      ano.val(data.idano);
      vin.val(data.vin);
      color.val(data.color);
      cliente.val(data.idcliente);
    }
  );
  $("#lbltitulo").html("Editar Registro");
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
}

$(document).on("click", "#btnnuevo", function () {
  /* TODO: Limpiar informacion */
  tipo.val("");
  placa.val("");
  marca.val("");
  modelo.val("");
  ano.val("");
  vin.val("");
  color.val("");
  cliente.val("");
  token.val("");
  $("#lbltitulo").html("Nuevo Registro");
  $("#mantenimiento_form")[0].reset();
  /* TODO: Mostrar Modal */
  $("#modalmantenimiento").modal("show");
});

init();


// VALIDACIONES //
function ValidarTipo(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("Seleccione tipo");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida PLACA
function ValidarPlaca(Control, Helper) {
  if (Control.val().trim()== "" || Control.val().length <= 0) {
    Helper.text("El numero de placa es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("La placa no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida MARCA
function ValidarMarca(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("La marca es requerida");
    Helper.show();
    return false;
  }
  Helper.hide();
  return true;
}

// valida Modelo
function ValidarModelo(Control, Helper) {
  if (Control.val().trim() == "" || Control.val().length <= 0) {
    Helper.text("Modelo de vehiculo requerida");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("El modelo no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida año
function ValidarAno(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("Seleccione año");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida VIN
function ValidarVin(Control, Helper) {
  if (Control.val().trim() == "" || Control.val().length <= 0) {
    Helper.text("El numero VIN es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9-ZñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("VIN no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida COLOR
function ValidarColor(Control, Helper) {
  if (Control.val().trim() == "" || Control.val().length <= 0) {
    Helper.text("El color es requerido");
    Helper.show();
    return false;
  }

  if (!Control.val().match(/^[a-zA-Z0-9-ZñÑáéíóúÁÉÍÓÚ ]+$/)) {
    Helper.text("Color no puede contener caracteres especiales");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

// valida CLIENTE
function ValidarCliente(Control, Helper) {
  if (!Control || Control.find(":selected").index() === 0) {
    Helper.text("Seleccione cliente");
    Helper.show();
    return false;
  }

  Helper.hide();
  return true;
}

//OCULTA MENSAJES HELPER
function OcultarHelpers() {
  tipohelper.hide();
  placahelper.hide();
  marcahelper.hide();
  modelohelper.hide();
  anohelper.hide();
  vinhelper.hide();
  colorhelper.hide();
  clientehelp.hide();
}

  //LIMPIA MENSAJES HELPER
  function LimpiarFormularios() {
    tipo.val("");
    placa.val("");
    marca.val("");
    modelo.val("");
    ano.val("");
    vin.val("");
    color.val("");
    cliente.val("");
  }

  // Borra helpers
  $("#modalmantenimiento").on("hidden.bs.modal", function () {
    OcultarHelpers();
    LimpiarFormularios();
  });

