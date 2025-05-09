<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlMarca.php");

/* TODO: Inicializando clases */
$marca = new mdlMarca();

switch ($_GET["op"]) {
    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $token = md5($_POST["marca"] . "+" . $_POST["marca"]);

            //Verificando si marca existe en BD
            $tabla = "marca";
            $item = "marca";
            $valor = $_POST["marca"];
            $validarMarca = $marca->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarMarca) {
                echo "error-marcaexiste";
                exit;
            }
            
            $marca->mdlRegistro(
                $token,
                $_POST["marca"]
            );
        } else {
            $nuevoToken = md5($_POST["marca"] . "+" . $_POST["marca"]);

            //Verificando si marca existe en BD
            $tabla = "marca";
            $item = "marca";
            $valor = $_POST["marca"];
            $validarMarca = $marca->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarMarca) {
                if ($validarMarca['token'] != $_POST["token"]) {
                echo "error-marcaexiste";
                exit;
                }
            }
        

            $marca->mdlActualizarRegistro(
                $_POST["marca"],
                $nuevoToken,
                $_POST["token"]    
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "marca";
        $datos = $marca->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["marca"];
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

    /*TODO: Mostrar informacion EDITAR egistro por token*/
    case "mostrar":
        $tabla = "marca";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $marca->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
           // foreach ($datos as $row) {
                $output["token"] = $datos["token"];
                $output["marca"] = $datos["marca"];
            }
            echo json_encode($output);
        // }
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $marca->mdlEliminarRegistro($_POST["token"]);
        break;
}
