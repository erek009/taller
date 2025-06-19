<?php

class mdlVenta extends Conectar
{

    /* TODO: Listar Registro por ID en especifico */
    public function mdlInsertaVenta($usu_id)
    {
        $conectar = parent::Conexion();
        $sql = "insertar_venta_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $usu_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //Registrar detalles producto 
    public function mdlRegistroDetalle($categoria, $refaccion, $venta_id, $undmedida, $precioventa, $cantidad)
    {
        $conectar = parent::Conexion();
        $sql = "insertarVentaDetalle ?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $categoria);
        $query->bindValue(2, $refaccion);
        $query->bindValue(3, $venta_id);
        $query->bindValue(4, $undmedida);
        $query->bindValue(5, $precioventa);
        $query->bindValue(6, $cantidad);
        $query->execute();
    }

    
    //SELECCIONAR PRODUCTOS POR CATEGORIA
    public function mdlSeleccionarDetalleVenta($compra_id)
    {
        $conectar = parent::Conexion();
        $sql = "EXEC seleccionarDetalleVenta @Venta_id = :venta_id";
        $query = $conectar->prepare($sql);

        $query->bindParam(":venta_id", $compra_id, PDO::PARAM_STR);
        $query->execute();

        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $resultado;
    }

    /* TODO: Listar Registro por ID en especifico */
    public function mdlCompra_Calculo($compra_id)
    {
        $conectar = parent::Conexion();
        $sql = "CalculoCostoVenta ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $compra_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

     /* TODO: guarda compra final */
    public function mdlGuarda_venta($venta_id, $clie_id, $clie_direccion, $clie_telefono, $comentario)
    {
        $conectar = parent::Conexion();
        $sql = "guarda_venta ?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $venta_id);
        $query->bindValue(2, $clie_id);
        $query->bindValue(3, $clie_direccion);
        $query->bindValue(4, $clie_telefono);
        $query->bindValue(5, $comentario);
        $query->execute();
    }

      //Eliminar registros
    public function mdlEliminarDetalleVenta($detalle_id)
    {
        $conectar = parent::Conexion();
        $sql = "EliminarDetalleVenta ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $detalle_id);
        $query->execute();
    }

     /* TODO:  actualiza stock */
    public function mdlActualizaStockVenta($venta_id)
    {
        $conectar = parent::Conexion();
        $sql = "testActualizaStockVenta ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $venta_id);
        $query->execute();
        // return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //MOSTRAR REGISTROS DE VENTA EN TICKET V+ = venta
    public function mdlSeleccionarVenta($venta_id)
    {
        $conectar = parent::Conexion();
        $sql = "EXEC seleccionarVenta @Venta_id = :venta_id";
        $query = $conectar->prepare($sql);

        $query->bindParam(":venta_id", $venta_id, PDO::PARAM_STR);
        $query->execute();

        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $resultado;
    }

     /* TODO: Listar Regista compra finalizada */
    public function mdlListarVentaFinalizada()
    {
        $conectar = parent::Conexion();
        $sql = "ListaVentaFinalizada ";
        $query = $conectar->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

       //Consultar registros GENERICO
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
}