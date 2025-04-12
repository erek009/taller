<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlVehiculo.php");

/* TODO: Inicializando clases */
$vehiculo = new mdlVehiculo();

switch ($_GET["op"]) {
    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {

            $token = md5($_POST["placa"] . "+" . $_POST["vin"]);

            //Verificando si servicio existe en BD
            $tabla = "vehiculo";
            $item = "placa";
            $valor = $_POST["placa"];
            $validarPlaca = $vehiculo->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarPlaca) {
                echo "error-vehiculoexiste";
                exit;
            }

            //Verificando si servicio existe en BD
            $tabla = "vehiculo";
            $item = "vin";
            $valor = $_POST["vin"];
            $validarVin = $vehiculo->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarVin) {
                echo "error-vehiculoexiste";
                exit;
            }

            $vehiculo->mdlRegistro(
                $token,
                $_POST["tipo"],
                $_POST["placa"],
                $_POST["marca"],
                $_POST["modelo"],
                $_POST["ano"],
                $_POST["vin"],
                $_POST["color"],
                $_POST["cliente"]
            );
        } else {
            $nuevoToken = md5($_POST["placa"] . "+" . $_POST["vin"]);

            $vehiculo->mdlActualizarRegistro(
                $_POST["tipo"],
                $_POST["placa"],
                $_POST["marca"],
                $_POST["modelo"],
                $_POST["ano"],
                $_POST["vin"],
                $_POST["color"],
                $_POST["cliente"],
                $nuevoToken,
                $_POST["token"]
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "vehiculo";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $vehiculo->mdlSeleccionarRegistrosVehiculo(null, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["tipo"];
            $sub_array[] = $row["placa"];
            $sub_array[] = $row["marca"];
            $sub_array[] = $row["model"];
            $sub_array[] = $row["ano"];
            $sub_array[] = $row["vin"];
            $sub_array[] = $row["color"];
            $sub_array[] = $row["nombre"];
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
        $tabla = "vehiculo";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $vehiculo->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["token"] = $row["token"];
                $output["tipo"] = $row["tipo"];
                $output["placa"] = $row["placa"];
                $output["idmarca"] = $row["idmarca"];
                $output["model"] = $row["model"];
                $output["idano"] = $row["idano"];
                $output["vin"] = $row["vin"];
                $output["color"] = $row["color"];
                $output["idcliente"] = $row["idcliente"];
            }
            echo json_encode($output);
        }
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $vehiculo->mdlEliminarRegistro($_POST["token"]);
        break;
}

