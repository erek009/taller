<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlNivel.php");

/* TODO: Inicializando clases */
$nivel = new mdlNivel();

switch ($_GET["op"]) {

    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $token = md5($_POST["nivel"] . "+" . $_POST["descripcion"]);

            ///Verificando si año existe en BD
            $tabla = "nivel";
            $item = "nivel";
            $valor = $_POST["nivel"];
            $validarNivel = $nivel->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarNivel) {
                echo "error-nivelexiste";
                exit;
            }

            $nivel->mdlRegistro(
                $token,
                $_POST["nivel"],
                $_POST["descripcion"]
            );
        } else {
            //EDITAR
            $nuevoToken = md5($_POST["nivel"] . "+" . $_POST["nivel"]);

            ///Verificando si año existe en BD
            $tabla = "nivel";
            $item = "nivel";
            $valor = $_POST["nivel"];
            $validarNivel = $nivel->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarNivel) {
                if ($validarNivel['token'] != $_POST["token"]) {
                    echo "error-nivelexiste";
                    exit;
                }
            }

            $nivel->mdlActualizarRegistro(
                $_POST["nivel"],
                $_POST["descripcion"],
                $nuevoToken,
                $_POST["token"]
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "nivel";
        $datos = $nivel->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["nivel"];
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
        $tabla = "nivel";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $nivel->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            $output["token"] = $datos["token"];
            $output["nivel"] = $datos["nivel"];
            $output["descripcion"] = $datos["descripcion"];
            echo json_encode($output);
        }
        break;


    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $tabla = "refacciones";
        $item = "idnivel";
        $valor = $_POST["token"]; // Token de anaquel que quieres eliminar

        $validarNivel = $nivel->mdlSeleccionarRegistros($tabla, $item, $valor);

        if (!empty($validarNivel)) {
            echo json_encode([
                "status" => "error",
                "message" => "No se puede eliminar este nivel porque está siendo utilizada en una refacción."
            ]);
            return;
        }

        $nivel->mdlEliminarRegistro($valor);
        echo json_encode([
            "status" => "ok",
            "message" => "Nivel eliminado correctamente"
        ]);
        return;
}
