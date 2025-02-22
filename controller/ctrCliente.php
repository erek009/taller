<?php 
/* TODO: Llamando clases */
    require_once("../config/conexion.php");
    require_once("../models/mdlCliente.php");

/* TODO: Inicializando clases */
    $cliente = new mdlCliente();

    switch($_GET["option"]){
        /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
        case "guardaryeditar":
            if(empty($_POST["token"])){
                
                $token = md5($_POST["nombre"] . "+" . $_POST["telefono"]);
                
                $cliente->mdlRegistro(
                    $token, 
                    $_POST["nombre"],
                    $_POST["direccion"],
                    $_POST["telefono"],
                    $_POST["localidad"],
                    $_POST["observaciones"]
                );
            }else{
                $nuevoToken = md5($_POST["nombre"] . "+" . $_POST["telefono"]);
                
                $cliente->mdlActualizarRegistro(
                    $_POST["token"],
                    $_POST["nombre"],
                    $_POST["direccion"],
                    $_POST["telefono"],
                    $_POST["localidad"],
                    $_POST["observaciones"],
                    $nuevoToken
                );
            }
            break;

        /*TODO: Listado de registros formato JSON para Datatable JS*/
        case "listar":
            $tabla = "cliente";
            $item = "token";
            $valor = $_POST["token"];
            $datos=$cliente->mdlSeleccionarRegistros($tabla,$item,$valor);
            $data=Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["direccion"];
                $sub_array[] = $row["telefono"];
                $sub_array[] = $row["localidad"];
                $sub_array[] = $row["observaciones"];
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
                $cliente->mdlEliminarRegistro($_POST["token"]);
            break;
    }

?>