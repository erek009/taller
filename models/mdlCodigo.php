<?php 

class mdlCodigo extends Conectar{

    //Registrar codigo
   public function mdlRegistro($token, $refaccion, $codigo) {
    try {
        $conectar = parent::Conexion();
        $sql = "EXEC insertarCodigo ?, ?, ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $refaccion);
        $query->bindValue(3, $codigo);
        $query->execute();
    } catch (PDOException $e) {
        // Puedes loguear o ignorar si el código ya existe
        error_log("Error al insertar código: " . $codigo . " — " . $e->getMessage());
    }
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
                return $query->fetch(PDO::FETCH_ASSOC);
            }
        }

    // //Eliminar registros
    //  public function mdlEliminarRegistro($token){
    //      $conectar=parent::Conexion();
    //      $sql="eliminarServicio ?";
    //      $query = $conectar->prepare($sql);
    //      $query->bindValue(1, $token);
    //      $query->execute();
    //  }

    //Actualizar registros
    public function mdlActualizarRegistro($refaccion, $codigo, $nuevoToken, $token){
        $conectar = parent::Conexion();
        $sql = "actualizarCodigo ?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $refaccion);
        $query->bindValue(2, $codigo);
        $query->bindValue(3, $nuevoToken);
        $query->bindValue(4, $token);
        $query->execute();
    }

     //Seleccionar registros vehiculo
    public function mdlSeleccionarRegistrosCodigo($tabla, $item, $valor)
    {
        $conectar = parent::Conexion();
        $sql = "seleccionarRegistroCodigos";
        $query = $conectar->prepare($sql);
        // $query->bindValue(1, $tabla);
        // $query->bindValue(1, $item);
        // $query->bindValue(1, $valor);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}


?>