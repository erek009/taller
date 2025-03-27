<?php 

class mdlRefaccion extends Conectar{

    //Registrar refaccion
    public function mdlRegistro($token,$codigo,$unidad,$marca,$stock,$proveedor,$venta,$compra,$descripcion){
        $conectar=parent::Conexion();
        $sql="insertarRefaccion ?,?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $codigo);
        $query->bindValue(3, $unidad);
        $query->bindValue(4, $marca);
        $query->bindValue(5, $stock);
        $query->bindValue(6, $proveedor);
        $query->bindValue(7, $venta);
        $query->bindValue(8, $compra);
        $query->bindValue(9, $descripcion);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //Consultar registros
    public function mdlSeleccionarRegistros($tabla, $item, $valor){
        if ($item == null && $valor == null) {
            $conectar=parent::Conexion();
            $sql="seleccionarRegistros ?";
            $query = $conectar->prepare($sql);
            $query->bindValue(1, $tabla);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $conectar=parent::Conexion();
            $sql="seleccionarRegistro ?,?,?";
            $query = $conectar->prepare($sql);
            $query->bindValue(1, $tabla);
            $query->bindValue(2, $item);
            $query->bindValue(3, $valor);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //Eliminar registros
     public function mdlEliminarRegistro($token){
         $conectar=parent::Conexion();
         $sql="eliminarRefaccion ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $token);
         $query->execute();
     }

    //Actualizar registros
    public function mdlActualizarRegistro($token,$nombre,$unidad,$marca,$proveedor,$venta,$compra,$descripcion){
        $conectar = parent::Conexion();
        $sql = "actualizarRefaccion ?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $nombre);
        $query->bindValue(2, $unidad);
        $query->bindValue(3, $marca);
        // $query->bindValue(3, $stock);
        $query->bindValue(4, $proveedor);
        $query->bindValue(5, $venta);
        $query->bindValue(6, $compra);
        $query->bindValue(7, $descripcion);
        $query->bindValue(8, $token);
        $query->execute();
    }

    //Actualizar stock
    public function mdlActualizaStock($cantidad,$refaccion){
        $conectar=parent::Conexion();
        $sql="actualizaStockVenta ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $cantidad);
        $query->bindValue(2, $refaccion);
        $query->execute();
    }
}


?>