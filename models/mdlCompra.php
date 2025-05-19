<?php 

class mdlCompra extends Conectar{

    //Registrar telefono
    public function mdlRegistro($refaccion,$proveedor,$undmedida,$preciocompra,$cantidad){
        $conectar=parent::Conexion();
        $sql="insertarCompra ?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $refaccion);
        $query->bindValue(2, $proveedor);
        $query->bindValue(3, $undmedida);
        $query->bindValue(4, $preciocompra);
        $query->bindValue(5, $cantidad);
        $query->execute();
    }


    
    //Seleccionar registros vehiculo
    public function mdlSeleccionarRegistrosCompra($tabla, $item, $valor)
    {
        $conectar = parent::Conexion();
        $sql = "seleccionarCompraDetalle";
        $query = $conectar->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //Eliminar registros
     public function mdlEliminarRegistro($id){
         $conectar=parent::Conexion();
         $sql="EliminarCompra ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $id);
         $query->execute();
     }

}