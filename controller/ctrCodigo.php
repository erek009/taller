<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlCodigo.php");

/* TODO: Inicializando clases */
$codigo = new mdlCodigo();

switch ($_GET["op"]) {
    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
   case "guardaryeditar":
    $refaccion = $_POST["refaccion"];
    $codigos_raw = $_POST["codigo"]; // viene del <textarea name="codigo">
    $codigos_array = array_filter(array_map('trim', explode("\n", $codigos_raw)));

    $repetidos = [];
    $guardados = [];

    if (empty($_POST["token"])) {
        // NUEVO REGISTRO — múltiples códigos
        foreach ($codigos_array as $codigoIndividual) {
            if (empty($codigoIndividual)) continue;

            $token = md5($codigoIndividual . "+" . $codigoIndividual);

            // Verificar si ya existe
            $tabla = "codigos";
            $item = "codigo";
            $valor = $codigoIndividual;
            $validar = $codigo->mdlSeleccionarRegistros($tabla, $item, $valor);

            if ($validar) {
                $repetidos[] = $codigoIndividual;
                continue;
            }

            $codigo->mdlRegistro($token, $refaccion, $codigoIndividual);
            $guardados[] = $codigoIndividual;
        }
    } else {
        // EDICIÓN — solo se permite editar un código
        $codigoEditar = trim($codigos_array[0]);
        $nuevoToken = md5($codigoEditar . "+" . $codigoEditar);

        $tabla = "codigos";
        $item = "codigo";
        $valor = $codigoEditar;
        $validar = $codigo->mdlSeleccionarRegistros($tabla, $item, $valor);

        if ($validar && $validar["token"] != $_POST["token"]) {
            $repetidos[] = $codigoEditar;
        } else {
            $codigo->mdlActualizarRegistro(
                $refaccion,
                $codigoEditar,
                $nuevoToken,
                $_POST["token"]
            );
            $guardados[] = $codigoEditar;
        }
    }

    echo json_encode([
        "status" => "ok",
        "guardados" => $guardados,
        "repetidos" => $repetidos
    ]);
    break;



        /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "codigos";
        // $item = "token";
        // $valor = $_POST["token"];
        $datos = $codigo->mdlSeleccionarRegistrosCodigo(null, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["codigo"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = date("d-m-Y H:i:s", strtotime($row["fech_crea"]));
            $sub_array[] = '<button type="button" onClick="editar(\'' . $row["token"] . '\')" id="' . $row["token"] . '" class="btn btn-warning btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar(\'' . $row["token"] . '\')" id="' . $row["token"] . '" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
            $data[] = $sub_array;
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    /*TODO: Mostrar informacion EDITAR registro por token*/
    case "mostrar":
        $tabla = "codigos";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $codigo->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            // foreach ($datos as $row) {
            $output["token"] = $datos["token"];
            $output["codigo"] = $datos["codigo"];
            $output["refaccion"] = $datos["refaccion"];
            // }
            echo json_encode($output);
        }
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $tabla = "codigos";
        $item = "codigo";
        $valor = $_POST["token"];

        $validarCodigo = $codigo->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (!empty($validarCodigo)) {
            echo json_encode([
                "status" => "error",
                "message" => "No se puede eliminar este codigo porque está siendo utilizado en una refaccion."
            ]);
            return;
        }

        $codigo->mdlEliminarRegistro($valor);
        echo json_encode([
            "status" => "ok",
            "message" => "Codigo eliminado correctamente"
        ]);
        return;
}
