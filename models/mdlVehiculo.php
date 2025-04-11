<?php

class mdlVehiculo extends Conectar
{

    //Registrar vehiculo
    public function mdlRegistro($token, $tipo, $placa, $marca, $modelo, $ano, $vin, $color, $cliente)
    {
        $conectar = parent::Conexion();
        $sql = "insertarVehiculo ?,?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $tipo);
        $query->bindValue(3, $placa);
        $query->bindValue(4, $marca);
        $query->bindValue(5, $modelo);
        $query->bindValue(6, $ano);
        $query->bindValue(7, $vin);
        $query->bindValue(8, $color);
        $query->bindValue(9, $cliente);
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
    public function mdlEliminarRegistro($token)
    {
        $conectar = parent::Conexion();
        $sql = "eliminarVehiculo ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->execute();
    }

    //Actualizar registros
    public function mdlActualizarRegistro($tipo, $placa, $marca, $modelo, $ano, $vin, $color, $cliente, $nuevoToken, $token)
    {
        $conectar = parent::Conexion();
        $sql = "actualizarVehiculo ?,?,?,?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $tipo);
        $query->bindValue(2, $placa);
        $query->bindValue(3, $marca);
        $query->bindValue(4, $modelo);
        $query->bindValue(5, $ano);
        $query->bindValue(6, $vin);
        $query->bindValue(7, $color);
        $query->bindValue(8, $cliente);
        $query->bindValue(9, $nuevoToken);
        $query->bindValue(10, $token);
        $query->execute();
    }

    //Seleccionar registros vehiculo
    public function mdlSeleccionarRegistrosVehiculo($tabla, $item, $valor)
    {
        $conectar = parent::Conexion();
        $sql = "seleccionarRegistroVehiculo";
        $query = $conectar->prepare($sql);
        // $query->bindValue(1, $tabla);
        // $query->bindValue(1, $item);
        // $query->bindValue(1, $valor);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
