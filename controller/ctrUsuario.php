<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlUsuario.php");

/* TODO: Inicializando clases */
$usuario = new mdlUsuario();

switch ($_GET["op"]) {
    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {
            $pass = crypt($_POST["password"], '$2a$07$Plu590nEp1uS9Pr0hA55elBAd$');
            $token = md5($_POST["nombre"] . "+" . $_POST["correo"]);

            //Verificando si servicio existe en BD
            $tabla = "usuarios";
            $item = "correo";
            $valor = $_POST["correo"];
            $validarEmail = $usuario->mdlSeleccionarRegistros($tabla, $item, $valor);
			if ($validarEmail) {
				echo 'error-correoexiste';
                exit;
			}

            $tabla = "usuarios";
            $item = "nombre";
            $valor = $_POST["nombre"];
            $validarNombre = $usuario->mdlSeleccionarRegistros($tabla, $item, $valor);
			if ($validarNombre) {
				echo 'error-nombreexiste';
                exit;
			}

            $usuario->mdlRegistro(
                $token,
                $_POST["nombre"],
                $_POST["correo"],
                $pass
            );
        } else {
            $nuevoToken = md5($_POST["nombre"] . "+" . $_POST["correo"]);

            $tabla = "usuarios";
            $item = "token";
            $valor = $_POST["token"];
            $validapass = $usuario->mdlSeleccionarRegistros($tabla, $item, $valor);
            $pass = empty($pass) ? $validapass['password'] : crypt($_POST["password"], '$2a$07$Plu590nEp1uS9Pr0hA55elBAd$');
            
            $usuario->mdlActualizarRegistro(
                $_POST["nombre"],
                $_POST["correo"],
                $pass,
                $nuevoToken,
                $_POST["token"]
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "usuarios";
        $datos = $usuario->mdlSeleccionarRegistros($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["correo"];
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
        $tabla = "usuarios";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $usuario->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $output["token"] = $row["token"];
                $output["nombre"] = $row["nombre"];
                $output["correo"] = $row["correo"];
                // $output["password"] = $row["password"];
            }
            echo json_encode($output);
        }
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $usuario->mdlEliminarRegistro($_POST["token"]);
        break;
}
