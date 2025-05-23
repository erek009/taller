<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlCompra.php");

/* TODO: Inicializando clases */
$compra = new mdlCompra();

switch ($_GET["op"]) {
    // registra ingreso nueva a compra
    case "registrar":
        $datos = $compra->insert_compra( $_POST["usu_id"]);
        foreach ($datos as $row) {
            $output["compra_id"] = $row["compra_id"];
        }
        echo json_encode($output);
        break;

    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "registrardetalle":
        $compra->mdlRegistro(
            $_POST["refaccion"],
            $_POST["proveedor"],
            $_POST["unidadmedida"],
            $_POST["preciocompra"],
            $_POST["cantidad"]
        );
        break;
    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "compra_detalle";
        $datos = $compra->mdlSeleccionarRegistrosCompra($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["razonsocial"];
            $sub_array[] = $row["unidadmedida"];
            $sub_array[] = $row["preciocompra"];
            $sub_array[] = $row["cantidad"];
            $sub_array[] = $row["total"];
            $sub_array[] = '<button type="button" onClick="eliminar(\'' . $row["id"] . '\')" id="' . $row["id"] . '" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
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

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $compra->mdlEliminarRegistro($_POST["id"]);
        break;

}
