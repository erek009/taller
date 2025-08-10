<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlVenta.php");

/* TODO: Inicializando clases */
$venta = new mdlVenta();
// $refaccion = new mdlRefaccion();

switch ($_GET["op"]) {
    // registra ingreso nueva venta
    case "registrar":
        $datos = $venta->mdlInsertaVenta( $_POST["usu_id"]);
        //Devuelve datos (id venta) con select del insert
        foreach ($datos as $row) {
            $output["venta_id"] = $row["venta_id"];
        }
        echo json_encode($output);
        break;

    /*TODO: Registra detalle compra*/
    case "registrardetalleproductos":

        //Verificando si hay stock suficiente
        $tabla = "refacciones";
        $item = "token";
        $valor = $_POST["refaccion"];

        $producto = $venta->mdlSeleccionarRegistros($tabla, $item, $valor);
        if ($producto) {
            // Comparar el stock disponible con la cantidad solicitada
            if ($_POST["cantidad"] > $producto["stock"]) {
                echo 'error-stockinsuficiente';
                exit;
            }
        }
            
        $venta->mdlRegistroDetalle(
            $_POST["refaccion"],
            $_POST["venta_id"],
            $_POST["unidadmedida"],
            $_POST["precioventa"],
            $_POST["cantidad"]
        );
        break;
      
    /*TODO: Listado de registros por venta_id*/
    case "listar":
        $venta_id = $_POST['venta_id'];
        $datos = $venta->mdlSeleccionarDetalleVenta($venta_id);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["unidadmedida"];
            $sub_array[] = $row["precioventa"];
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
        $datos = $venta->mdlCompra_Calculo($_POST["venta_id"]);
         foreach ($datos as $row) {
            $output["venta_subtotal"] = $row["venta_subtotal"];
            $output["venta_iva"] = $row["venta_iva"];
            $output["venta_total"] = $row["venta_total"];
        }
        echo json_encode($output);
        break;

        /*TODO: Registra detalle compra*/
    case "guardarVenta":
        $venta->mdlGuarda_venta(
            $_POST["venta_id"],
            $_POST["clie_id"],
            $_POST["clie_direccion"],
            $_POST["clie_telefono"],
            $_POST["comentario"]
        );

        $venta->mdlActualizaStockVenta(
            $_POST["venta_id"]
        );
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $venta->mdlEliminarDetalleVenta($_POST["detalle_id"]);
        break;

          /*TODO: Listado detalle de compra formato (PDF)*/
    case "listarDetalleProductosVenta":
        $venta_id = $_POST['venta_id'];
        $datos = $venta->mdlSeleccionarDetalleVenta($venta_id);
        // $data = array();
        foreach ($datos as $row) {
        ?>
            <tr>
                <th><?php echo $row["categoria"]; ?></th>
                <td><?php echo $row["nombre"]; ?></td>
                <td><?php echo $row["unidadmedida"]; ?></td>
                <td><?php echo $row["precioventa"]; ?></td>
                <td><?php echo $row["cantidad"]; ?></td>
                <td class="text-end"><?php echo $row["total"]; ?></td>
            </tr>
        <?php
        }
        break;

      //TODO: muestra formato tipo PDF de Lista compra
    case "mostrarDatosVenta":
        $venta_id = $_POST['venta_id'];
        $datos = $venta->mdlSeleccionarVenta($venta_id);
         foreach ($datos as $row) {
            $output["venta_id"] = $row["venta_id"];
            $output["fech_crea"] = $row["fech_crea"];
            $output["venta_iva"] = $row["venta_iva"];
            $output["venta_subtotal"] = $row["venta_subtotal"];
            $output["venta_total"] = $row["venta_total"];
            $output["clie_id"] = $row["nombre"];
            $output["clie_direccion"] = $row["direccion"];
            $output["clie_telefono"] = $row["telefono"];
            $output["usu_nom"] = $row["nombre"];
            $output["venta_comentario"] = $row["venta_comentario"];

        }
        echo json_encode($output);
        break;

       /*TODO: Listado compras realizadas*/
    case "listaventasfinalizadas":
        $tabla = "venta";
        $datos = $venta->mdlListarVentaFinalizada($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = "V-".$row["venta_id"];
                $sub_array[] = $row["nombre"];
                $sub_array[] = $row["telefono"];
                $sub_array[] = $row["venta_subtotal"];
                $sub_array[] = $row["venta_total"];
                // $sub_array[] = $row["nombre"];
                $sub_array[] = $row["fech_crea"];
                $sub_array[] = '<a href="../../view/ViewVenta/?v='.$row["venta_id"].'" target="_blank" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-printer-line"></i></a>';
                $sub_array[] = '<a type="button" onClick="ver(' . $row["venta_id"] . ')" id="' . $row["venta_id"] . '" class="btn btn-success btn-icon waves-effect waves-light"> <i class="ri-settings-2-line"></i></a>';
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

        // TODO: Buscar producto por nombre o código
    case "buscar_producto":
        require_once("../models/mdlRefaccion.php");
        $producto = new mdlRefaccion();

        $termino = $_POST["termino"];
        $resultado = $producto->buscarPorNombreOCodigo($termino);

        if ($resultado) {
            echo json_encode($resultado);
        } else {
            echo json_encode(null);
        }
        break;
}