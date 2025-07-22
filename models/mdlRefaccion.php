<?php

class mdlRefaccion extends Conectar
{

    //Registrar refaccion
    public function mdlRegistro($token, $codigo, $categoria, $nombre, $unidad, $marca, $stock, $compra, $venta, $anaquel, $nivel, $descripcion, $prod_img)
    {
        $conectar = parent::Conexion();

        //sube la imagen del producto
        require_once("mdlRefaccion.php");
        $prod = new mdlRefaccion();
        $prod_img = '';
        if ($_FILES["prod_img"]["name"] != '') {
            $prod_img = $prod->guardar_imagen();
        }

        $sql = "insertarRefaccion ?,?,?,?,?,?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $codigo);
        $query->bindValue(3, $categoria);
        $query->bindValue(4, $nombre);
        $query->bindValue(5, $unidad);
        $query->bindValue(6, $marca);
        $query->bindValue(7, $stock);
        $query->bindValue(8, $compra);
        $query->bindValue(9, $venta);
        $query->bindValue(10, $anaquel);
        $query->bindValue(11, $nivel);
        $query->bindValue(12, $descripcion);
        $query->bindValue(13, $prod_img);
        $query->execute();
    }

    //Consultar registros
    public function mdlSeleccionarRegistros($tabla, $item, $valor)
    {
        if ($item == null && $valor == null) {
            $conectar = parent::Conexion();
            $sql = "seleccionarRegistros ?";
            $query = $conectar->prepare($sql);
            $query->bindValue(1, $tabla);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $conectar = parent::Conexion();
            $sql = "seleccionarRegistro ?,?,?";
            $query = $conectar->prepare($sql);
            $query->bindValue(1, $tabla);
            $query->bindValue(2, $item);
            $query->bindValue(3, $valor);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    //Eliminar registros
    public function mdlEliminarRegistro($token)
    {
        $conectar = parent::Conexion();
        $sql = "eliminarRefaccion ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->execute();
    }

    public function mdlActualizarRegistro($categoria, $nombre, $unidad, $marca, $compra, $venta, $anaquel, $nivel, $descripcion, $prod_img, $token)
    {
        $conectar = parent::Conexion();

        //sube la imagen del producto
        require_once("mdlRefaccion.php");
        $prod = new mdlRefaccion();
        $prod_img = '';
        if ($_FILES["prod_img"]["name"] != '') {
            $prod_img = $prod->guardar_imagen();
        } else {
            $prod_img = $POST["hidden_producto_imagen"];
        }

        $sql = "actualizarRefaccion ?,?,?,?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        // Conversión a float para evitar errores con SQL Server
        $venta = floatval($venta);
        $compra = floatval($compra);

        $query->bindValue(1, $categoria);
        $query->bindValue(2, $nombre);
        $query->bindValue(3, $unidad);
        $query->bindValue(4, $marca);
        $query->bindValue(5, $compra);
        $query->bindValue(6, $venta);
        $query->bindValue(7, $anaquel);
        $query->bindValue(8, $nivel);
        $query->bindValue(9, $descripcion);
        $query->bindValue(10, $prod_img);
        $query->bindValue(11, $token);
        $query->execute();
    }

    //Actualizar stock
    public function mdlActualizaStock($cantidad, $refaccion)
    {
        $conectar = parent::Conexion();
        $sql = "actualizaStockVenta ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $cantidad);
        $query->bindValue(2, $refaccion);
        $query->execute();
    }


    //Seleccionar registros vehiculo
    public function mdlSeleccionarRefacciones($tabla, $item, $valor)
    {
        $conectar = parent::Conexion();
        $sql = "seleccionarRefaccion";
        $query = $conectar->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }


    //SELECCIONAR PRODUCTOS POR CATEGORIA
    public function mdlSeleccionarProductosPorCategoria($categoria_id) {
    $conectar = parent::Conexion();

    // Parámetros nombrados explícitamente
    $sql = "EXEC seleccionarPorCategoria @p_categoria_id = :categoria_id";
    $query = $conectar->prepare($sql);
    $query->bindParam(":categoria_id", $categoria_id, PDO::PARAM_STR);
    $query->execute();
    $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    $query->closeCursor();

    return $resultado;
}

/* TODO: Registrar Imagen */
    public function guardar_imagen()
    {
        if (isset($_FILES["prod_img"])) {
            $extension = explode('.', $_FILES['prod_img']['name']);
            $new_name = rand() . '.' . $extension[1];
            $destination = '../assets/producto/' . $new_name;
            move_uploaded_file($_FILES['prod_img']['tmp_name'], $destination);
            return $new_name;
        }
    }


}
