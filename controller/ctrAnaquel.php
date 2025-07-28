<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlAnaquel.php");

/* TODO: Inicializando clases */
$anaquel = new mdlAnaquel();

switch ($_GET["op"]) {

    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $token = md5($_POST["anaquel"] . "+" . $_POST["descripcion"]);

            ///Verificando si año existe en BD
            $tabla = "anaquel";
            $item = "anaquel";
            $valor = $_POST["anaquel"];
            $validarAnaquel = $anaquel->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarAnaquel) {
                echo "error-anaquelexiste";
                exit;
            }

            $anaquel->mdlRegistro(
                $token,
                $_POST["anaquel"],
                $_POST["descripcion"]
            );
        } else {
            //EDITAR
            $nuevoToken = md5($_POST["anaquel"] . "+" . $_POST["anaquel"]);

            ///Verificando si año existe en BD
            $tabla = "anaquel";
            $item = "anaquel";
            $valor = $_POST["anaquel"];
            $validarAnaquel = $anaquel->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarAnaquel) {
                if ($validarAnaquel['token'] != $_POST["token"]) {
                    echo "error-anaquelexiste";
                    exit;
                }
            }

            $anaquel->mdlActualizarRegistro(
                $_POST["anaquel"],
                $_POST["descripcion"],
                $nuevoToken,
                $_POST["token"]
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "anaquel";
        $datos = $anaquel->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["anaquel"];
            $sub_array[] = $row["descripcion"];
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
        $tabla = "anaquel";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $anaquel->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            $output["token"] = $datos["token"];
            $output["anaquel"] = $datos["anaquel"];
            $output["descripcion"] = $datos["descripcion"];
            echo json_encode($output);
        }
        break;


    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $tabla = "refacciones";
        $item = "idanaquel";
        $valor = $_POST["token"]; // Token de anaquel que quieres eliminar

        $validarAnaquel = $anaquel->mdlSeleccionarRegistros($tabla, $item, $valor);

        if (!empty($validarAnaquel)) {
            echo json_encode([
                "status" => "error",
                "message" => "No se puede eliminar este anaquel porque está siendo utilizada en una refacción."
            ]);
            return;
        }

        $anaquel->mdlEliminarRegistro($valor);
        echo json_encode([
            "status" => "ok",
            "message" => "Anaquel eliminado correctamente"
        ]);
        return;
}
