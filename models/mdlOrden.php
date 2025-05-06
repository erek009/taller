<?php 

class mdlOrden extends Conectar{

    //Registrar telefono
    public function mdlRegistro($token,$vehiculo,$concepto,$combustible,$kilometros,$tecnico,$servicio){
        $conectar=parent::Conexion();
        $sql="insertarOrden ?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $vehiculo);
        $query->bindValue(3, $concepto);
        $query->bindValue(4, $combustible);
        $query->bindValue(5, $kilometros);
        $query->bindValue(6, $tecnico);
        $query->bindValue(7, $servicio);
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
            return $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    //Eliminar registros
     public function mdlEliminarRegistro($token){
         $conectar=parent::Conexion();
         $sql="eliminarOrden ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $token);
         $query->execute();
     }

    //Actualizar registros
    public function mdlActualizarRegistro($vehiculo,$concepto,$combustible,$kilometros,$tecnico,$servicio,$nuevoToken,$token){
        $conectar = parent::Conexion();
        $sql = "actualizarOrden ?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $vehiculo);
        $query->bindValue(2, $concepto);
        $query->bindValue(3, $combustible);
        $query->bindValue(4, $kilometros);
        $query->bindValue(5, $tecnico);
        $query->bindValue(6, $servicio);
        $query->bindValue(7, $nuevoToken);
        $query->bindValue(8, $token);
        $query->execute();
    }


    //Seleccionar registros vehiculo
    public function mdlSeleccionarRegistrosVehiculo($tabla, $item, $valor)
    {
        $conectar = parent::Conexion();
        $sql = "seleccionarRegistroOrden";
        $query = $conectar->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>