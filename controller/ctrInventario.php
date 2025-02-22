<?php 
/* TODO: Llamando clases */
    require_once("../config/conexion.php");
    require_once("../models/mdlInventario.php");

/* TODO: Inicializando clases */
    $inventario = new mdlInventario();

    switch($_GET["option"]){
        /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
        case "guardaryeditar":
            if(empty($_POST["token"])){
                
                $token = md5($_POST["placa"] . "+" . $_POST["vin"]);
                $inventario->mdlRegistro(
                    $token, 
                    $_POST["nombre"],
                    $_POST["stock"],
                    $_POST["movimiento"],
                    $_POST["usuario"]
                );
            // }else{
            //     $nuevoToken = md5($_POST["placa"] . "+" . $_POST["vin"]);

            //     $inventario->mdlActualizarRegistro(
            //         $_POST["token"],
            //         $_POST["tipo"],
            //         $_POST["placa"],
            //         $_POST["marca"],
            //         $_POST["ano"],
            //         $_POST["vin"],
            //         $_POST["color"],
            //         $_POST["cliente"],
            //         $_POST["model"],
            //         $nuevoToken
            //     );
             }
            break;

        /*TODO: Listado de registros formato JSON para Datatable JS*/
        case "listar":
            $tabla = "inventario";
            $item = "token";
            $valor = $_POST["token"];
            $datos=$inventario->mdlSeleccionarRegistros($tabla,$item,$valor);
            $data=Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["stock"];
                $sub_array[] = $row["movimiento"];
                $sub_array[] = $row["usuario"];
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
        
        // /*TODO: Eliminar (cambia estado a 0 del registro)*/
        // case "eliminar":
        //         $inventario->mdlEliminarRegistro($_POST["token"]);
        //     break;
    }

?>