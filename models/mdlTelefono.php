<?php 

class mdlTelefono extends Conectar{

    //Registrar telefono
    public function mdlRegistro($token,$telefono){
        $conectar=parent::Conexion();
        $sql="insertarTelefono ?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $telefono);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //Consultar registros
    public function mdlSeleccionarRegistros($tabla, $item, $valor){
    if ($item == null && $valor == null) {
        $conectar=parent::Conexion();
        $sql="seleccionarRegistro ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $tabla);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $conectar=parent::Conexion();
        $sql="seleccionarRegistros ?,?,?";
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
         $sql="eliminarTelefono ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $token);
         $query->execute();
     }

    //Actualizar registros
    public function mdlActualizarRegistro($telefono,$nuevoToken,$token){
        $conectar = parent::Conexion();
        $sql = "actualizarTelefono ?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $telefono);
        $query->bindValue(2, $nuevoToken);
        $query->bindValue(3, $token);
        $query->execute();
    }

}


?>