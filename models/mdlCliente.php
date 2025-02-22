<?php 

class mdlCliente extends Conectar{

    //Registrar refaccion
    public function mdlRegistro($token,$nombre,$direccion,$telefono,$localidad,$observaciones){
        $conectar=parent::Conexion();
        $sql="insertarCliente ?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $nombre);
        $query->bindValue(3, $direccion);
        $query->bindValue(4, $telefono);
        $query->bindValue(5, $localidad);
        $query->bindValue(6, $observaciones);
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
         $sql="eliminarCliente ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $token);
         $query->execute();
     }

    //Actualizar registros
    public function mdlActualizarRegistro($nombre,$direccion,$telefono,$localidad,$observaciones,$nuevotoken,$token){
        $conectar = parent::Conexion();
        $sql = "actualizarCliente ?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $nombre);
        $query->bindValue(2, $direccion);
        $query->bindValue(3, $telefono);
        $query->bindValue(4, $localidad);
        $query->bindValue(5, $observaciones);
        $query->bindValue(6, $nuevotoken);
        $query->bindValue(7, $token);
        $query->execute();
    }


}


?>