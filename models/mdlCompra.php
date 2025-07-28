<?php

class mdlCompra extends Conectar
{

    /* TODO: Listar Registro por ID en especifico */
    public function mdlInsertaCompra($usu_id)
    {
        $conectar = parent::Conexion();
        $sql = "insertar_compra_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $usu_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //Registrar 
    public function mdlRegistro($refaccion, $compra_id, $undmedida, $preciocompra, $cantidad)
    {
        $conectar = parent::Conexion();
        $sql = "insertarCompraDetalle ?,?,?,?,?";
        $query = $conectar->prepare($sql);
        // $query->bindValue(1, $categoria);
        $query->bindValue(1, $refaccion);
        $query->bindValue(2, $compra_id);
        $query->bindValue(3, $undmedida);
        $query->bindValue(4, $preciocompra);
        $query->bindValue(5, $cantidad);
        $query->execute();
    }

    //SELECCIONAR PRODUCTOS POR CATEGORIA
    public function mdlSeleccionarRegistrosCompra($compra_id)
    {
        $conectar = parent::Conexion();
        $sql = "EXEC seleccionarCompraDetalle @Compra_id = :compra_id";
        $query = $conectar->prepare($sql);

        $query->bindParam(":compra_id", $compra_id, PDO::PARAM_STR);
        $query->execute();

        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $resultado;
    }

    /* TODO: Listar Registro por ID en especifico */
    public function mdlCompra_Calculo($compra_id)
    {
        $conectar = parent::Conexion();
        $sql = "updateCompra_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $compra_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /* TODO: actualiza compra final */
    public function mdlGuarda_compra($compra_id, $prov_id, $prov_rfc, $prov_direccion, $prov_email, $prov_telefono, $comentario)
    {
        $conectar = parent::Conexion();
        $sql = "guarda_compra ?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $compra_id);
        $query->bindValue(2, $prov_id);
        $query->bindValue(3, $prov_rfc);
        $query->bindValue(4, $prov_direccion);
        $query->bindValue(5, $prov_email);
        $query->bindValue(6, $prov_telefono);
        $query->bindValue(7, $comentario);
        $query->execute();
    }

    //Eliminar registros
    public function mdlEliminarDetalleCompra($detalle_id)
    {
        $conectar = parent::Conexion();
        $sql = "EliminarDetalleCompra ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $detalle_id);
        $query->execute();
    }

      /* TODO: actualiza stock */
    public function mdlActualizaStockCompra($compra_id)
    {
        $conectar = parent::Conexion();
        $sql = "testActualizaCompraStock ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $compra_id);
        $query->execute();
        // return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //MOSTRAR REGISTROS DE COMPRA EN TICKET
    public function mdlSeleccionarCompra($compra_id)
    {
        $conectar = parent::Conexion();
        $sql = "EXEC seleccionarCompra @Compra_id = :compra_id";
        $query = $conectar->prepare($sql);

        $query->bindParam(":compra_id", $compra_id, PDO::PARAM_STR);
        $query->execute();

        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        $query->closeCursor();
        return $resultado;
    }

    /* TODO: Listar Regista compra finalizada */
    public function mdlListarCompraFinalizada()
    {
        $conectar = parent::Conexion();
        $sql = "ListaCompraFinalizada ";
        $query = $conectar->prepare($sql);
        // $query->bindValue(1, $compra_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

   

}
