<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlRol.php");

/* TODO: Inicializando clases */
$rol = new mdlRol();

switch ($_GET["op"]) {

    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $token = md5($_POST["rol_nombre"] . "+" . $_POST["rol_nombre"]);

            ///Verificando si año existe en BD
            $tabla = "rol_usuario";
            $item = "rol_nombre";
            $valor = $_POST["rol_nombre"];
            $validarRol = $rol->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarRol) {
                echo "error-rolexiste";
                exit;
            }

            $rol->mdlRegistro(
                $token,
                $_POST["rol_nombre"]
            );
        } else {
            //EDITAR
            $nuevoToken = md5($_POST["rol_nombre"] . "+" . $_POST["rol_nombre"]);

            ///Verificando si año existe en BD
            $tabla = "rol_usuario";
            $item = "rol_nombre";
            $valor = $_POST["rol_nombre"];
            $validarRol = $rol->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarRol) {
                if ($validarRol['token'] != $_POST["token"]) {
                    echo "error-rolexiste";
                    exit;
                }
            }

            $rol->mdlActualizarRegistro(
                $_POST["rol_nombre"],
                $nuevoToken,
                $_POST["token"]
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
   case "listar":
        $tabla = "rol_usuario";
        $datos = $rol->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["rol_nombre"];
            $sub_array[] = $row["fech_crea"];

                $sub_array[] = '<button type="button" onClick="permiso(\'' . $row["token"] . '\')" id="' . $row["token"] . '" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-settings-2-line"></i></button>';
                
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
        $tabla = "rol_usuario";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $rol->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            // foreach ($datos as $row) {
            $output["token"] = $datos["token"];
            $output["rol_nombre"] = $datos["rol_nombre"];
            // }
            echo json_encode($output);
        }
        break;


    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $tabla = "rol_usuario";
        $item = "token"; 
        $valor = $_POST["token"]; // Token de la categoría que quieres eliminar

        $validarRol = $rol->mdlSeleccionarRegistros($tabla, $item, $valor);
        if ($validarRol["rol_nombre"] === "administrador") {
            echo json_encode([
                "status" => "error",
                "message" => "No se puede eliminar administrador"
            ]);
            return;
        }

         $rol->mdlEliminarRegistro($valor);
        echo json_encode([
            "status" => "ok",
            "message" => "Rol usuario eliminado correctamente"
        ]);
        return;
}
