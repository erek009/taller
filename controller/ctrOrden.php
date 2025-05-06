<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlOrden.php");

/* TODO: Inicializando clases */
$orden = new mdlOrden();

switch ($_GET["op"]) {
    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {

            $token = md5($_POST["vehiculo"] . "+" . $_POST["vehiculo"]);

            $orden->mdlRegistro(
                $token,
                $_POST["vehiculo"],
                $_POST["concepto"],
                $_POST["combustible"],
                $_POST["kilometros"],
                $_POST["tecnico"],
                $_POST["servicio"]

            );
        } else {
            $nuevoToken = md5($_POST["vehiculo"] . "+" . $_POST["vehiculo"]);

            $orden->mdlActualizarRegistro(
                $_POST["vehiculo"],
                $_POST["concepto"],
                $_POST["combustible"],
                $_POST["kilometros"],
                $_POST["tecnico"],
                $_POST["servicio"],
                $nuevoToken,
                $_POST["token"],
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "ordenes";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $orden->mdlSeleccionarRegistrosVehiculo(null, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["id"];
            $sub_array[] = $row["placa"];
            $sub_array[] = $row["concepto"];
            $sub_array[] = $row["nivelcombustible"];
            $sub_array[] = $row["kilometros"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["nombreservicio"];
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
        $tabla = "ordenes";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $orden->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            // foreach ($datos as $row) {
            $output["token"] = $datos["token"];
            $output["idvehiculo"] = $datos["idvehiculo"];
            $output["concepto"] = $datos["concepto"];
            $output["nivelcombustible"] = $datos["nivelcombustible"];
            $output["kilometros"] = $datos["kilometros"];
            $output["idusuario"] = $datos["idusuario"];
            $output["idservicio"] = $datos["idservicio"];
            // }
            echo json_encode($output);
        }
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $orden->mdlEliminarRegistro($_POST["token"]);
        break;
}
