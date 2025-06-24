<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlRefaccion.php");

/* TODO: Inicializando clases */
$refaccion = new mdlRefaccion();

switch ($_GET["op"]) {
    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "guardaryeditar":
        if (empty($_POST["token"])) {

            $token = md5($_POST["codigo"] . "+" . $_POST["codigo"]);

            //Verificando si servicio existe en BD
            $tabla = "refacciones";
            $item = "codigo";
            $valor = $_POST["codigo"];
            $validarProducto = $refaccion->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarProducto) {
                echo 'error-productoexiste';
                exit;
            }

            //Verificando si servicio existe en BD
            $tabla = "refacciones";
            $item = "nombre";
            $valor = $_POST["nombreproducto"];
            $validarNombre = $refaccion->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarNombre) {
                echo 'error-productoexiste';
                exit;
            }

            $refaccion->mdlRegistro(
                $token,
                $_POST["codigo"],
                $_POST["categoria"],
                $_POST["nombreproducto"],
                $_POST["unidadmedida"],
                $_POST["marca"],
                $_POST["stock"],
                $_POST["preciocompra"],
                $_POST["precioventa"],
                $_POST["descripcion"],
                $_POST["prod_img"]
            );
        } else {

            //Verificando si servicio existe en BD
            $tabla = "refacciones";
            $item = "nombre";
            $valor = $_POST["nombreproducto"];
            $validarNombre = $refaccion->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarNombre) {
                if ($validarNombre['token'] != $_POST["token"]) {
                    echo 'error-productoexiste';
                    exit;
                }
            }
            $refaccion->mdlActualizarRegistro(
                $_POST["categoria"],
                $_POST["nombreproducto"],
                $_POST["unidadmedida"],
                $_POST["marca"],
                $_POST["preciocompra"],
                $_POST["precioventa"],
                $_POST["descripcion"],
                $_POST["prod_img"],
                $_POST["token"]
            );
        }
        break;

    /*TODO: Listado de registros formato JSON para Datatable JS*/
    case "listar":
        $tabla = "refacciones";
        $datos = $refaccion->mdlSeleccionarRefacciones($tabla, null, null);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();

            if ($row["prod_img"] != ''){
                    $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                        "<div class='flex-shrink-0 me-2'>".
                            "<img src='../../assets/producto/".$row["prod_img"]."' alt='' class='avatar-xs rounded-circle'>".
                        "</div>".
                    "</div>";
                }else{
                    $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                        "<div class='flex-shrink-0 me-2'>".
                            "<img src='../../assets/producto/no_imagen.avif' alt='' class='avatar-xs rounded-circle'>".
                        "</div>".
                    "</div>";
                }
            $sub_array[] = $row["codigo"];
            $sub_array[] = $row["categoria"];
            $sub_array[] = $row["nombre"];
            $sub_array[] = $row["unidadmedida"];
            $sub_array[] = $row["marca"];
            $sub_array[] = $row["stock"];
            $sub_array[] = $row["preciocompra"];
            $sub_array[] = $row["precioventa"];
            $sub_array[] = $row["descripcion"];
            $sub_array[] = '<button type="button" onClick="editar(\'' . $row["token"] . '\')" id="' . $row["token"] . '" class="btn btn-warning btn-icon waves-effect waves-light"><i class="ri-edit-2-line"></i></button>';
            $sub_array[] = '<button type="button" onClick="eliminar(\'' . $row["token"] . '\')" id="' . $row["token"] . '" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-5-line"></i></button>';
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

    /*TODO: Mostrar informacion EDITAR registro por token*/
    case "mostrar":
        $tabla = "refacciones";
        $item = "token";
        $valor = $_POST["token"];
        $datos = $refaccion->mdlSeleccionarRegistros($tabla, $item, $valor);
        if (is_array($datos) == true and count($datos) > 0) {
            // foreach ($datos as $row) {
            $output["token"] = $datos["token"];
            $output["codigo"] = $datos["codigo"];
            $output["idcategoria"] = $datos["idcategoria"];
            $output["nombre"] = $datos["nombre"];
            $output["unidadmedida"] = $datos["unidadmedida"];
            $output["marca"] = $datos["marca"];
            $output["stock"] = $datos["stock"];
            $output["preciocompra"] = $datos["preciocompra"];
            $output["precioventa"] = $datos["precioventa"];
            $output["descripcion"] = $datos["descripcion"];
            if($datos["prod_img"] != ''){
                    $output["prod_img"] = '<img src="../../assets/producto/'.$datos["prod_img"].'" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="'.$datos["prod_img"].'" />';
                }else{
                    $output["prod_img"] = '<img src="../../assets/producto/no_imagen.avif" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image"></img><input type="hidden" name="hidden_producto_imagen" value="" />';
                }
            echo json_encode($output);
        }
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    case "eliminar":
        $refaccion->mdlEliminarRegistro($_POST["token"]);
        break;

     /*TODO: Muestra productos en select por categoria)*/
    case "productos_por_categoria":
        $categoria_id = $_POST['categoria_id'];
        $data = $refaccion->mdlSeleccionarProductosPorCategoria($categoria_id);
        echo json_encode($data);
        break;
}
