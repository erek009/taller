<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlCompra.php");

/* TODO: Inicializando clases */
$compra = new mdlCompra();

switch ($_GET["op"]) {
    // registra ingreso nueva a compra
    case "registrar":
        $datos = $compra->mdlInsertaCompra( $_POST["usu_id"]);
        //Devuelve datos con select del insert
        foreach ($datos as $row) {
            $output["compra_id"] = $row["compra_id"];
        }
        echo json_encode($output);
        break;

    /*TODO: Registra detalle compra*/
    case "registrardetalleproductos":
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

    //TODO: calculo de costo compra
    case "calculo":
        $datos = $compra->mdlCompra_Calculo($_POST["compra_id"]);
         foreach ($datos as $row) {
            $output["compra_subtotal"] = $row["compra_subtotal"];
            $output["compra_iva"] = $row["compra_iva"];
            $output["compra_total"] = $row["compra_total"];
        }
        echo json_encode($output);
        break;

    /*TODO: Registra detalle compra*/
    case "guardarCompra":
        $compra->mdlGuarda_compra(
            $_POST["compra_id"],
            $_POST["prov_id"],
            $_POST["prov_rfc"],
            $_POST["prov_direccion"],
            $_POST["prov_email"],
            $_POST["prov_telefono"],
            $_POST["comentario"]
        );

        $compra->mdlActualizaStockCompra(
            $_POST["compra_id"]
        );
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $compra->mdlEliminarDetalleCompra($_POST["detalle_id"]);
        break;


        /*TODO: Listado detalle de compra formato (PDF)*/
    case "listarDetalleProductosCompra":
        $compra_id = $_POST['compra_id'];
        $datos = $compra->mdlSeleccionarRegistrosCompra($compra_id);
        // $data = array();
        foreach ($datos as $row) {
        ?>
            <tr>
                <th><?php echo $row["categoria"]; ?></th>
                <td><?php echo $row["nombre"]; ?></td>
                <td><?php echo $row["unidadmedida"]; ?></td>
                <td><?php echo $row["preciocompra"]; ?></td>
                <td><?php echo $row["cantidad"]; ?></td>
                <td class="text-end"><?php echo $row["total"]; ?></td>
            </tr>
        <?php
        }
        break;

        
    //TODO: muestra formato tipo PDF de Lista compra
    case "mostrarDatosCompra":
        $compra_id = $_POST['compra_id'];
        $datos = $compra->mdlSeleccionarCompra($compra_id);
         foreach ($datos as $row) {
            $output["compra_id"] = $row["compra_id"];
            $output["fech_crea"] = $row["fech_crea"];
            $output["compra_iva"] = $row["compra_iva"];
            $output["compra_subtotal"] = $row["compra_subtotal"];
            $output["compra_total"] = $row["compra_total"];
            $output["prov_id"] = $row["razonsocial"];
            $output["prov_rfc"] = $row["rfc"];
            $output["prov_direccion"] = $row["direccion"];
            $output["prov_correo"] = $row["email"];
            $output["prov_telefono"] = $row["telefono"];
            $output["usu_nom"] = $row["nombre"];
            $output["compra_comentario"] = $row["compra_comentario"];

        }
        echo json_encode($output);
        break;

    /*TODO: Listado compras realizadas*/
    case "listacomprasfinalizadas":
        $tabla = "compra";
        $datos = $compra->mdlListarCompraFinalizada($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = "C-".$row["compra_id"];
                $sub_array[] = $row["razonsocial"];
                $sub_array[] = $row["rfc"];
                $sub_array[] = $row["compra_subtotal"];
                $sub_array[] = $row["compra_total"];
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["fech_crea"];
                $sub_array[] = '<a href="../../view/ViewCompra/?c='.$row["compra_id"].'" target="_blank" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-printer-line"></i></a>';
                $sub_array[] = '<a type="button" onClick="ver(' . $row["compra_id"] . ')" id="' . $row["compra_id"] . '" class="btn btn-success btn-icon waves-effect waves-light"> <i class="ri-settings-2-line"></i></a>';
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

    }