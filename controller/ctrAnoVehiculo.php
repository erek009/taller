<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlAnoVehiculo.php");

/* TODO: Inicializando clases */
$anoovehiculo = new mdlAnoVehiculo();

switch ($_GET["op"]) {

    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $token = md5($_POST["AnoVehiculo"] . "+" . $_POST["AnoVehiculo"]);

            ///Verificando si año existe en BD
            $tabla = "ano";
            $item = "ano";
            $valor = $_POST["AnoVehiculo"];
            $validarAno = $anoovehiculo->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarAno) {
                echo "error-anoexiste";
                exit;
            }

            $anoovehiculo->mdlRegistro(
                $token,
                $_POST["AnoVehiculo"]
            );
        } else {
            //EDITAR
            $nuevoToken = md5($_POST["AnoVehiculo"] . "+" . $_POST["AnoVehiculo"]);

            ///Verificando si año existe en BD
            $tabla = "ano";
            $item = "ano";
            $valor = $_POST["AnoVehiculo"];
            $validarAno = $anoovehiculo->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarAno) {
                if ($validarAno != $_POST["token"]) {
                echo "error-anoexiste";
                exit;
            }
        }

            $anoovehiculo->mdlActualizarRegistro(
                $_POST["AnoVehiculo"],
                $nuevoToken,
                $_POST["token"]
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "ano";
        $datos = $anoovehiculo->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["ano"];
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


    /*TODO: Mostrar informacion de registro por ID*/
    case "mostrar":
        $tabla = "ano";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $anoovehiculo->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["token"] = $row["token"];
                $output["ano"] = $row["ano"];
            }
            echo json_encode($output);
        }
        break;


    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $anoovehiculo->mdlEliminarRegistro($_POST["token"]);
        // echo json_encode($_POST["token"]);
        break;
}
