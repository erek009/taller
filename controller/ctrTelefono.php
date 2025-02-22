<?php 
/* TODO: Llamando clases */
    require_once("../config/conexion.php");
    require_once("../models/mdlTelefono.php");

/* TODO: Inicializando clases */
    $telefono = new mdlTelefono();

    switch($_GET["option"]){
        /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
        case "guardaryeditar":
            if(empty($_POST["token"])){
                
                $token = md5($_POST["telefono"] . "+" . $_POST["telefono"]);
                
                $telefono->mdlRegistro(
                    $token, 
                    $_POST["telefono"]
                );
            }else{
                $nuevoToken = md5($_POST["telefono"] . "+" . $_POST["telefono"]);
                
                $telefono->mdlActualizarRegistro(
                    $_POST["token"],
                    $_POST["telefono"],
                    $nuevoToken
                );
            }
            break;

        /*TODO: Listado de registros formato JSON para Datatable JS*/
        case "listar":
            $tabla = "telefono";
            $item = "token";
            $valor = $_POST["token"];
            $datos=$telefono->mdlSeleccionarRegistros($tabla,$item,$valor);
            $data=Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["telefono"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["TOKEN"].')" id="'.$row["TOKEN"].'" class="btn btn-warning btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["TOKEN"].')" id="'.$row["TOKEN"].'" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
                $data[] = $sub_array;
            }
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
            break;
        
        /*TODO: Eliminar (cambia estado a 0 del registro)*/
        case "eliminar":
                $telefono->mdlEliminarRegistro($_POST["token"]);
            break;
    }

?>