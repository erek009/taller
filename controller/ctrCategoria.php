<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlCategoria.php");

/* TODO: Inicializando clases */
$categoria = new mdlCategoria();

switch ($_GET["op"]) {

    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $token = md5($_POST["categoria"] . "+" . $_POST["categoria"]);

            ///Verificando si año existe en BD
            $tabla = "categoria";
            $item = "categoria";
            $valor = $_POST["categoria"];
            $validarCategoria = $categoria->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarCategoria) {
                echo "error-categoriaexiste";
                exit;
            }

            $categoria->mdlRegistro(
                $token,
                $_POST["categoria"]
            );
        } else {
            //EDITAR
            $nuevoToken = md5($_POST["categoria"] . "+" . $_POST["categoria"]);

            ///Verificando si año existe en BD
            $tabla = "categoria";
            $item = "categoria";
            $valor = $_POST["categoria"];
            $validarCategoria = $categoria->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarCategoria) {
                if ($validarCategoria['token'] != $_POST["token"]) {
                    echo "error-categoriaexiste";
                    exit;
                }
            }

            $categoria->mdlActualizarRegistro(
                $_POST["categoria"],
                $nuevoToken,
                $_POST["token"]
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "categoria";
        $datos = $categoria->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["categoria"];
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
        $tabla = "categoria";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $categoria->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            // foreach ($datos as $row) {
            $output["token"] = $datos["token"];
            $output["categoria"] = $datos["categoria"];
            // }
            echo json_encode($output);
        }
        break;


    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $tabla = "refacciones";
        $item = "idcategoria"; 
        $valor = $_POST["token"]; // Token de la categoría que quieres eliminar

        $validarCategoria = $categoria->mdlSeleccionarRegistros($tabla, $item, $valor);

        if (!empty($validarCategoria)) {
            echo json_encode([
                "status" => "error",
                "message" => "No se puede eliminar esta categoría porque está siendo utilizada en una refacción."
            ]);
            return;
        }

         $categoria->mdlEliminarRegistro($valor);
        echo json_encode([
            "status" => "ok",
            "message" => "Categoria eliminada correctamente"
        ]);
        return;
}
