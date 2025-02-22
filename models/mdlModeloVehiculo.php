<?php 

class mdlModeloVehiculo extends Conectar{

    //Registrar modelo vehiculo
    public function mdlRegistro($token,$modelo){
        $conectar=parent::Conexion();
        $sql="insertarModelo ?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $modelo);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //Consultar registros
    public function mdlSeleccionarRegistros($tabla){
        $conectar=parent::Conexion();
        $sql="seleccionarRegistro ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $tabla);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //Eliminar registros
     public function mdlEliminarRegistro($token){
         $conectar=parent::Conexion();
         $sql="eliminarModelo ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $token);
         $query->execute();
     }

    //Actualizar registros
    public function mdlActualizarRegistro($modelo,$nuevoToken,$token){
        $conectar = parent::Conexion();
        $sql = "actualizarTelefono ?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $modelo);
        $query->bindValue(2, $nuevoToken);
        $query->bindValue(3, $token);
        $query->execute();
    }

}


?>