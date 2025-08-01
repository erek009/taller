<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlRefaccion.php");

/* TODO: Inicializando clases */
$refaccion = new mdlRefaccion();

switch ($_GET["op"]) {
    case "guardaryeditar":
        // Variable para el nombre de la imagen a guardar
        $nombre_imagen = '';

        // Ruta absoluta para la carpeta donde guardar la imagen
        $ruta = __DIR__ . "/../assets/producto/";

        // Crear carpeta si no existe
        if (!file_exists($ruta)) {
            mkdir($ruta, 0755, true);
        }

        // Validar si llegó archivo y moverlo
        if (isset($_FILES['prod_img']) && $_FILES['prod_img']['error'] == 0) {
            $nombre_imagen = uniqid() . '_' . $_FILES['prod_img']['name'];
            if (!move_uploaded_file($_FILES['prod_img']['tmp_name'], $ruta . $nombre_imagen)) {
                echo "error-subidaimagen";
                exit;
            }
        } else {
            // Si no hay nueva imagen, usar la imagen actual enviada en el input hidden
            $nombre_imagen = $_POST['hidden_producto_imagen'] ?? '';
        }

        if (empty($_POST["token"])) {
            $token = md5($_POST["codigo"] . "+" . $_POST["codigo"]);

            // Validar si el producto ya existe por código
            $tabla = "refacciones";
            $item = "codigo";
            $valor = $_POST["codigo"];
            $validarProducto = $refaccion->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarProducto) {
                echo 'error-productoexiste';
                exit;
            }

            // Validar si el producto ya existe por nombre
            $tabla = "refacciones";
            $item = "nombre";
            $valor = $_POST["nombreproducto"];
            $validarNombre = $refaccion->mdlSeleccionarRegistros($tabla, $item, $valor);
            if ($validarNombre) {
                echo 'error-productoexiste';
                exit;
            }

            // Registrar con el nombre correcto de la imagen
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
                $_POST["anaquel"],
                $_POST["nivel"],
                $_POST["descripcion"],
                $nombre_imagen
            );
        } else {
            // Validar nombre para actualización
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

            // Actualizar con el nombre correcto de la imagen
            $refaccion->mdlActualizarRegistro(
                $_POST["categoria"],
                $_POST["nombreproducto"],
                $_POST["unidadmedida"],
                $_POST["marca"],
                $_POST["preciocompra"],
                $_POST["precioventa"],
                $_POST["anaquel"],
                $_POST["nivel"],
                $_POST["descripcion"],
                $nombre_imagen,
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

            if ($row["prod_img"] != '') {
                $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>" .
                    "<img src='../../assets/producto/" . $row["prod_img"] . "' alt='' class='avatar-xs rounded-circle'>" .
                    "</div>" .
                    "</div>";
            } else {
                $sub_array[] =
                    "<div class='d-flex align-items-center'>" .
                    "<div class='flex-shrink-0 me-2'>" .
                    "<img src='../../assets/producto/no_imagen.avif' alt='' class='avatar-xs rounded-circle'>" .
                    "</div>" .
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
            $sub_array[] = $row["anaquel"];
            $sub_array[] = $row["nivel"];
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
            $output["token"] = $datos["token"];
            $output["codigo"] = $datos["codigo"];
            $output["idcategoria"] = $datos["idcategoria"];
            $output["nombre"] = $datos["nombre"];
            $output["unidadmedida"] = $datos["unidadmedida"];
            $output["marca"] = $datos["marca"];
            $output["stock"] = $datos["stock"];
            $output["preciocompra"] = $datos["preciocompra"];
            $output["precioventa"] = $datos["precioventa"];
            $output["idanaquel"] = $datos["idanaquel"];
            $output["idnivel"] = $datos["idnivel"];
            $output["descripcion"] = $datos["descripcion"];
            // Solo enviar nombre o ruta de la imagen (sin etiquetas HTML)
            $output["prod_img"] = ($datos["prod_img"] != '') ? $datos["prod_img"] : 'no_imagen.avif';
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
