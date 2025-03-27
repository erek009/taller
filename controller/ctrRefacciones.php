<?php 
/* TODO: Llamando clases */
    require_once("../config/conexion.php");
    require_once("../models/mdlRefaccion.php");

/* TODO: Inicializando clases */
    $refaccion = new mdlRefaccion();

    switch($_GET["op"]){
        /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
        case "guardaryeditar":
            if(empty($_POST["token"])){
                
                $token = md5($_POST["codigo"] . "+" . $_POST["codigo"]);
                
                $refaccion->mdlRegistro(
                    $token, 
                    $_POST["codigo"],
                    $_POST["nombre"],
                    $_POST["unidad"],
                    $_POST["marca"],
                    $_POST["stock"],
                    $_POST["proveedor"],
                    $_POST["venta"],
                    $_POST["compra"],
                    $_POST["descripcion"]
                );
            }else{
                // $nuevoToken = md5($_POST["codigo"] . "+" . $_POST["codigo"]);
                
                $refaccion->mdlActualizarRegistro(
                    $_POST["token"],
                    // $_POST["codigo"],
                    $_POST["nombre"],
                    $_POST["unidad"],
                    $_POST["marca"],
                    // $_POST["stock"],
                    $_POST["proveedor"],
                    $_POST["venta"],
                    $_POST["compra"],
                    $_POST["descripcion"]
                    // $nuevoToken
                );
            }
            break;

        /*TODO: Listado de registros formato JSON para Datatable JS*/
        case "listar":
            $tabla = "refacciones";
            $datos=$refaccion->mdlSeleccionarRegistros($tabla, null, null);
            $data=Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["codigo"];
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["unidadmedida"];
                $sub_array[] = $row["marca"];
                $sub_array[] = $row["stock"];
                $sub_array[] = $row["proveedor"];
                $sub_array[] = $row["preciocompra"];
                $sub_array[] = $row["precioventa"];
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
                $refaccion->mdlEliminarRegistro($_POST["token"]);
            break;
    }

?>