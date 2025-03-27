<?php 
/* TODO: Llamando clases */
    require_once("../config/conexion.php");
    require_once("../models/mdlServicio.php");

/* TODO: Inicializando clases */
    $servicio = new mdlServicio();

    switch($_GET["op"]){
        /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
        case "guardaryeditar":
            if(empty($_POST["token"])){
                
                $token = md5($_POST["servicio"] . "+" . $_POST["servicio"]);
                
                $servicio->mdlRegistro(
                    $token, 
                    $_POST["nombreservicio"],
                    $_POST["costomobra"],
                    $_POST["descripcion"]
                );
            }else{
                $nuevoToken = md5($_POST["servicio"] . "+" . $_POST["servicio"]);
                
                $servicio->mdlActualizarRegistro(
                    $_POST["token"],
                    $_POST["nombreservicio"],
                    $_POST["costomobra"],
                    $_POST["descripcion"],
                    $nuevoToken
                );
            }
            break;

        /*TODO: Listado de registros formato JSON para Datatable JS*/
        case "listar":
            $tabla = "servicio";
            $datos=$servicio->mdlSeleccionarRegistros($tabla, null, null);
            $data = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["nombreservicio"];
                $sub_array[] = $row["costomobra"];
                $sub_array[] = $row["descripcion"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["token"].')" id="'.$row["token"].'" class="btn btn-warning btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["token"].')" id="'.$row["token"].'" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
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
                $servicio->mdlEliminarRegistro($_POST["token"]);
            break;
    }

?>