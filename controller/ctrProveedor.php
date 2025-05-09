<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlProveedor.php");

/* TODO: Inicializando clases */
$proveedor = new mdlProveedor();

switch ($_GET["op"]) {

    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $token = md5($_POST["razonsocial"] . "+" . $_POST["rfc"]);
            ///Verificando si razonsocial existe en BD
            $tabla = "proveedores";
            $item = "razonsocial";
            $valor = $_POST["razonsocial"];
            $validarRazonsocial = $proveedor->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarRazonsocial) {
                echo "error-proveedorexiste";
                exit;
            }

            ///Verificando si rfc existe en BD
            $tabla = "proveedores";
            $item = "rfc";
            $valor = $_POST["rfc"];
            $validarRFC = $proveedor->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarRFC) {
                echo "error-proveedorexiste";
                exit;
            }
            $proveedor->mdlRegistro(
                $token,
                $_POST["razonsocial"],
                $_POST["rfc"],
                $_POST["telefono"],
                $_POST["email"]
            );
        } else {
            //EDITAR
            $nuevoToken = md5($_POST["razonsocial"] . "+" . $_POST["rfc"]);

            //Verificando si proveedor existe en BD
            $tabla = "proveedores";
            $item = "razonsocial";
            $valor = $_POST["razonsocial"];
            $validarRazonsocial = $proveedor->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarRazonsocial) {
                if ($validarRazonsocial['token'] != $_POST["token"]) {
                echo "error-proveedorexiste";
                exit;
                }
            }

             //Verificando si proveedor existe en BD
             $tabla = "proveedores";
             $item = "rfc";
             $valor = $_POST["rfc"];
             $validarRFC = $proveedor->mdlSeleccionarRegistros($tabla, $item, $valor);
             if ($validarRFC) {
                 if ($validarRFC['token'] != $_POST["token"]) {
                 echo "error-proveedorexiste";
                 exit;
                 }
             }

            $proveedor->mdlActualizarRegistro(
                $_POST["razonsocial"],
                $_POST["rfc"],
                $_POST["telefono"],
                $_POST["email"],
                $nuevoToken,
                $_POST["token"]
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "proveedores";
        $datos = $proveedor->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["razonsocial"];
            $sub_array[] = $row["rfc"];
            $sub_array[] = $row["telefono"];
            $sub_array[] = $row["email"];
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
        $tabla = "proveedores";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $proveedor->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            // foreach ($datos as $row) {
            $output["token"] = $datos["token"];
            $output["razonsocial"] = $datos["razonsocial"];
            $output["rfc"] = $datos["rfc"];
            $output["telefono"] = $datos["telefono"];
            $output["email"] = $datos["email"];
            // }
            echo json_encode($output);
        }
        break;


    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $proveedor->mdlEliminarRegistro($_POST["token"]);
        break;
}
