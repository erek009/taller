<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlAnoVehiculo.php");

/* TODO: Inicializando clases */
$AnoVehiculo = new mdlAnoVehiculo();

switch ($_GET["op"]) {
        /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {

            $token = md5($_POST["ano"] . "+" . $_POST["ano"]);

            $AnoVehiculo->mdlRegistro(
                $token,
                $_POST["AnoVehiculo"]
            );
        } else {
            $nuevoToken = md5($_POST["ano"] . "+" . $_POST["ano"]);

            $AnoVehiculo->mdlActualizarRegistro(
                $_POST["token"],
                $nuevoToken,
                $_POST["ano"]
            );
        }
        break;

        /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "ano";
        // $item = "id";
        // $valor = $_POST["token"];
        $datos = $AnoVehiculo->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();

        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["ano"];
             $sub_array[] = $row["token"];
            // $sub_array[] = '<button type="button" onClick="editar(' . $row["token"] . ')" id="' . $row["token"] . '" class="btn btn-warning btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar(' . $row["token"] . ')" id="' . $row["token"] . '" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
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

        /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $AnoVehiculo->mdlEliminarRegistro($_POST["token"]);
        break;
}
