<?php 

class mdlServicio extends Conectar{

    //Registrar servicio
    public function mdlRegistro($token, $nombreservicio, $costomobra, $descripcion){
        $conectar=parent::Conexion();
        $sql="insertarServicio ?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $nombreservicio);
        $query->bindValue(3, $costomobra);
        $query->bindValue(4, $descripcion);
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
         $sql="eliminarServicio ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $token);
         $query->execute();
     }

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

}


?>