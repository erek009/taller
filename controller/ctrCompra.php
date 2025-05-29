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
        //Devuelve datos con select del insert
        foreach ($datos as $row) {
            $output["compra_id"] = $row["compra_id"];
        }
        echo json_encode($output);
        break;

    /*TODO: Registra detalle compra*/
    case "registrardetallecompra":
        $compra->mdlRegistro(
            $_POST["categoria"],
            $_POST["refaccion"],
            $_POST["compra_id"],
            $_POST["unidadmedida"],
            $_POST["preciocompra"],
            $_POST["cantidad"]
        );
        break;
    /*TODO: Listado de registros por compra_id*/
    case "listar":
        $compra_id = $_POST['compra_id'];
        $datos = $compra->mdlSeleccionarRegistrosCompra($compra_id);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["categoria"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["unidadmedida"];
            $sub_array[] = $row["preciocompra"];
            $sub_array[] = $row["cantidad"];
            $sub_array[] = $row["total"];
            $sub_array[] = '<button type="button" onClick="eliminar(\'' . $row["detalle_id"] . '\')" id="' . $row["detalle_id"] . '" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
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

    case "calculo":
        $datos = $compra->compra_calculo($_POST["compra_id"]);
         foreach ($datos as $row) {
            $output["compra_subtotal"] = $row["compra_subtotal"];
            $output["compra_iva"] = $row["compra_iva"];
            $output["compra_total"] = $row["compra_total"];
        }
        echo json_encode($output);
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $compra->mdlEliminarRegistro($_POST["detalle_id"]);
        break;

}
