<?php 

class mdlRefaccion extends Conectar{

    //Registrar refaccion
    public function mdlRegistro($token, $codigo, $nombre, $unidad, $marca, $stock, $proveedor, $compra, $venta, $descripcion){
        $conectar=parent::Conexion();
        $sql="insertarRefaccion ?,?,?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $codigo);
        $query->bindValue(3, $nombre);
        $query->bindValue(4, $unidad);
        $query->bindValue(5, $marca);
        $query->bindValue(6, $stock);
        $query->bindValue(7, $proveedor);
        $query->bindValue(8, $compra);
        $query->bindValue(9, $venta);
        $query->bindValue(10, $descripcion);
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

     public function mdlActualizarRegistro($nombre, $unidad, $marca, $proveedor, $compra, $venta, $descripcion, $token){
        $conectar = parent::Conexion();
        $sql = "actualizarRefaccion ?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
    
        // Conversión a float para evitar errores con SQL Server
        $venta = floatval($venta);
        $compra = floatval($compra);
    
        $query->bindValue(1, $nombre);
        $query->bindValue(2, $unidad);
        $query->bindValue(3, $marca);
        $query->bindValue(4, $proveedor);
        $query->bindValue(5, $compra);
        $query->bindValue(6, $venta);
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