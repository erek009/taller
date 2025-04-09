<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlServicio.php");

/* TODO: Inicializando clases */
$servicio = new mdlServicio();

switch ($_GET["op"]) {
    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $token = md5($_POST["servicio"] . "+" . $_POST["servicio"]);

            //Verificando si servicio existe en BD
            $tabla = "servicio";
            $item = "nombreservicio";
            $valor = $_POST["servicio"];
            $validarServicio = $servicio->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarServicio) {
                echo "error-servicioexiste";
                exit;
            }

            $servicio->mdlRegistro(
                $token,
                $_POST["servicio"],
                $_POST["costo"],
                $_POST["descripcion"]
            );
        } else {
            $nuevoToken = md5($_POST["servicio"] . "+" . $_POST["servicio"]);

            //Verificando si servicio existe en BD
            $tabla = "servicio";
            $item = "nombreservicio";
            $valor = $_POST["servicio"];
            $validarServicio = $servicio->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarServicio) {
                if ($validarServicio['token'] != $token) {
                echo "error-servicioexiste";
                exit;
                }
            }

            $servicio->mdlActualizarRegistro(
                $_POST["servicio"],
                $_POST["costo"],
                $_POST["descripcion"],
                $nuevoToken,
                $_POST["token"],
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "servicio";
        $datos = $servicio->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["nombreservicio"];
            $sub_array[] = $row["costomobra"];
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

    /*TODO: Mostrar informacion EDITAR registro por token*/
    case "mostrar":
        $tabla = "servicio";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $servicio->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["token"] = $row["token"];
                $output["nombreservicio"] = $row["nombreservicio"];
                $output["costomobra"] = $row["costomobra"];
                $output["descripcion"] = $row["descripcion"];
            }
            echo json_encode($output);
        }
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $servicio->mdlEliminarRegistro($_POST["token"]);
        break;
}
