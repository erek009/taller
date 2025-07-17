<?php

class mdlAnaquel extends Conectar
{

    //Registrar
    public function mdlRegistro($token, $anaquel, $descripcion)
    {
        $conectar = parent::Conexion();
        $sql = "insertarAnaquel ?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $anaquel);
        $query->bindValue(3, $descripcion);
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
            return $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    //Eliminar registros
    public function mdlEliminarRegistro($token)
    {
        $conectar = parent::Conexion();
        $sql = "eliminarAnaquel ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->execute();
    }

  //Actualizar registros
    public function mdlActualizarRegistro($anaquel, $descripcion, $nuevoToken, $token)
    {
        $conectar = parent::Conexion();
        $sql = "actualizarAnaquel ?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $anaquel);
        $query->bindValue(2, $descripcion);
        $query->bindValue(3, $nuevoToken);
        $query->bindValue(4, $token);
        $query->execute();
    }

}
