<?php

class mdlCompra extends Conectar
{

    /* TODO: Listar Registro por ID en especifico */
    public function insert_compra($usu_id)
    {
        $conectar = parent::Conexion();
        $sql = "insertar_compra_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $usu_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //Registrar telefono
    public function mdlRegistro($refaccion, $compra_id, $undmedida, $preciocompra, $cantidad)
    {
        $conectar = parent::Conexion();
        $sql = "insertarCompra ?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $refaccion);
        $query->bindValue(2, $compra_id);
        $query->bindValue(3, $undmedida);
        $query->bindValue(4, $preciocompra);
        $query->bindValue(5, $cantidad);
        $query->execute();
    }


    //Seleccionar registros vehiculo

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


    //Eliminar registros
    public function mdlEliminarRegistro($id)
    {
        $conectar = parent::Conexion();
        $sql = "EliminarCompra ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $id);
        $query->execute();
    }
}
