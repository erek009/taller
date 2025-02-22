<?php 

class mdlVehiculo extends Conectar{

    //Registrar vehiculo
    public function mdlRegistro($token,$tipo,$placa,$marca,$ano,$vin,$color,$cliente,$model){
        $conectar=parent::Conexion();
        $sql="insertarVehiculo ?,?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $tipo);
        $query->bindValue(3, $placa);
        $query->bindValue(4, $marca);
        $query->bindValue(5, $ano);
        $query->bindValue(6, $vin);
        $query->bindValue(7, $color);
        $query->bindValue(8, $cliente);
        $query->bindValue(9, $model);
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
         $sql="eliminarVehiculo ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $token);
         $query->execute();
     }

    //Actualizar registros
    public function mdlActualizarRegistro($tipo,$placa,$marca,$ano,$vin,$color,$cliente,$model,$nuevoToken,$token){
        $conectar = parent::Conexion();
        $sql = "actualizarVehiculo ?,?,?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $tipo);
        $query->bindValue(2, $placa);
        $query->bindValue(3, $marca);
        $query->bindValue(4, $ano);
        $query->bindValue(5, $vin);
        $query->bindValue(6, $color);
        $query->bindValue(7, $cliente);
        $query->bindValue(8, $model);
        $query->bindValue(9, $nuevoToken);
        $query->bindValue(10, $token);
        $query->execute();
    }

    //Seleccionar registros vehiculo
    public function mdlSeleccionarRegistrosVehiculo($tabla,$item,$valor){
        $conectar=parent::Conexion();
        $sql="seleccionarRegistroVehiculo ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $tabla);
        $query->bindValue(1, $item);
        $query->bindValue(1, $valor);
        $query->execute();
    }

}


?>