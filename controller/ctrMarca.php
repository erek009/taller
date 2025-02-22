<?php 
/* TODO: Llamando clases */
    require_once("../config/conexion.php");
    require_once("../models/mdlMarca.php");

/* TODO: Inicializando clases */
    $Marca = new mdlMarca();

    switch($_GET["option"]){
        /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
        case "guardaryeditar":
            if(empty($_POST["token"])){
                
                $token = md5($_POST["marca"] . "+" . $_POST["marca"]);
                $Marca->mdlRegistro($token, $_POST["marca"]);
            }else{
                $nuevoToken = md5($_POST["marca"] . "+" . $_POST["marca"]);
                $Marca->mdlActualizarRegistro($_POST["token"], $nuevoToken, $_POST["marca"]);
            }
            break;

        /*TODO: Listado de registros formato JSON para Datatable JS*/
        case "listar":
            $tabla = "marca";
            $item = "token";
            $valor = $_POST["token"];
            $datos=$Marca->mdlSeleccionarRegistros($tabla,$item,$valor);
            $data=Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["marca"];
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
                $Marca->mdlEliminarRegistro($_POST["token"]);
            break;
    }

?>