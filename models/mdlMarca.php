<?php 

class mdlMarca extends Conectar{

    //Registrar telefono
    public function mdlRegistro($token,$marca){
        $conectar=parent::Conexion();
        $sql="insertarMarca ?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $marca);
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

    //Eliminar registros
     public function mdlEliminarRegistro($token){
         $conectar=parent::Conexion();
         $sql="eliminarMarca ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $token);
         $query->execute();
     }

    //Actualizar registros
    public function mdlActualizarRegistro($marca, $nuevoToken, $token){
        $conectar = parent::Conexion();
        $sql = "actualizarMarca ?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $marca);
        $query->bindValue(2, $nuevoToken);
        $query->bindValue(3, $token);
        $query->execute();
    }

}


?>