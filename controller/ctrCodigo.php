<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlCodigo.php");

/* TODO: Inicializando clases */
$codigo = new mdlCodigo();

switch ($_GET["op"]) {
    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $token = md5($_POST["codigo"] . "+" . $_POST["codigo"]);

            //Verificando si codigo existe en BD
            $tabla = "codigos";
            $item = "codigo";
            $valor = $_POST["codigo"];
            $validarCodigo = $codigo->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarCodigo) {
                echo "error-codigoexiste";
                exit;
            }

            $codigo->mdlRegistro(
                $token,
                $_POST["refaccion"],
                $_POST["codigo"]
            );
        } else {
            $nuevoToken = md5($_POST["codigo"] . "+" . $_POST["codigo"]);

            //Verificando si servicio existe en BD
            $tabla = "codigos";
            $item = "codigo";
            $valor = $_POST["codigo"];
            $validarCodigo = $codigo->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarCodigo) {
                if ($validarCodigo['token'] != $_POST["token"]) {
                    echo "error-codigoexiste";
                    exit;
                }
            }

            //     $codigo->mdlActualizarRegistro(
            //         $_POST["refaccion"],
            //         $_POST["codigo"],
            //         $nuevoToken,
            //         $_POST["token"],
            //     );
            // }
            // break;
        } //BORRARRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRRR

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
}
