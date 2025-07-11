<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlMenu.php");

/* TODO: Inicializando clases */
$menu = new mdlMenu();
// $refaccion = new mdlRefaccion();

switch ($_GET["op"]) {

    /*TODO: Listado de registros por venta_id*/
    case "listar":
        $rol = $_POST['token'];
        $datos = $menu->mdlMenu_x_rol_id($rol);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["menu_nombre"];
            if ($row["permiso"] == "Si") {
                $sub_array[] = '<button type="button"  onClick="deshabilitar(' . $row["detalle_id"] . ')" id="' . $row["detalle_id"] . '" class="btn btn-success btn-label btn-sm"><i class="ri-check-double-line label-icon align-middle fs-16 me-2"></i>' . $row["permiso"] . '</button>';
            } else {
                $sub_array[] = '<button type="button" onClick="habilitar(' . $row["detalle_id"] . ')" id="' . $row["detalle_id"] . '" class="btn btn-danger btn-label btn-sm"><i class="ri-close-circle-line label-icon align-middle fs-16 me-2"></i> ' . $row["permiso"] . '</button>';
            }
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

    case "habilitar":
        $menu->mdlUpdate_menu_habilitar($_POST["detalle_id"]);
        break;


    case "deshabilitar":
        $menu->mdlUpdate_menu_deshabilitar($_POST["detalle_id"]);
        break;
}
