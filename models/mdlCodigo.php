<?php 

class mdlCodigo extends Conectar{

    //Registrar codigo
    public function mdlRegistro($token, $refaccion, $codigo){
        $conectar=parent::Conexion();
        $sql="insertarCodigo ?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $refaccion);
        $query->bindValue(3, $codigo);
        $query->execute();
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
    public function mdlActualizarRegistro($nombreservicio, $costomobra, $descripcion, $nuevoToken, $token){
        $conectar = parent::Conexion();
        $sql = "actualizarServicio ?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $nombreservicio);
        $query->bindValue(2, $costomobra);
        $query->bindValue(3, $descripcion);
        $query->bindValue(4, $nuevoToken);
        $query->bindValue(5, $token);
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