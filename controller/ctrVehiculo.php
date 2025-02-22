<?php 
/* TODO: Llamando clases */
    require_once("../config/conexion.php");
    require_once("../models/mdlVehiculo.php");

/* TODO: Inicializando clases */
    $vehiculo = new mdlVehiculo();

    switch($_GET["option"]){
        /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
        case "guardaryeditar":
            if(empty($_POST["token"])){
                
                $token = md5($_POST["placa"] . "+" . $_POST["vin"]);
                $vehiculo->mdlRegistro(
                    $token, 
                    $_POST["tipo"],
                    $_POST["placa"],
                    $_POST["marca"],
                    $_POST["ano"],
                    $_POST["vin"],
                    $_POST["color"],
                    $_POST["cliente"],
                    $_POST["model"]
                );
            }else{
                $nuevoToken = md5($_POST["placa"] . "+" . $_POST["vin"]);

                $vehiculo->mdlActualizarRegistro(
                    $_POST["token"],
                    $_POST["tipo"],
                    $_POST["placa"],
                    $_POST["marca"],
                    $_POST["ano"],
                    $_POST["vin"],
                    $_POST["color"],
                    $_POST["cliente"],
                    $_POST["model"],
                    $nuevoToken
                );
            }
            break;

        /*TODO: Listado de registros formato JSON para Datatable JS*/
        case "listar":
            $tabla = "vehiculo";
            $item = "token";
            $valor = $_POST["token"];
            $datos=$vehiculo->mdlSeleccionarRegistros($tabla,$item,$valor);
            $data=Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tipo"];
                $sub_array[] = $row["placa"];
                $sub_array[] = $row["marca"];
                $sub_array[] = $row["ano"];
                $sub_array[] = $row["vin"];
                $sub_array[] = $row["color"];
                $sub_array[] = $row["cliente"];
                $sub_array[] = $row["model"];
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
                $vehiculo->mdlEliminarRegistro($_POST["token"]);
            break;
    }

?>