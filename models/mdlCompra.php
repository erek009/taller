<?php 

class mdlCompra extends Conectar{

    //Registrar telefono
    public function mdlRegistro($refaccion,$preciocompra, $cantidad){
        $conectar=parent::Conexion();
        $sql="insertarCompra ?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $refaccion);
        $query->bindValue(2, $preciocompra);
        $query->bindValue(3, $cantidad);
        $query->execute();
    }


}