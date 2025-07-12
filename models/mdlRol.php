<?php

class mdlRol extends Conectar
{

    //Registrar
    public function mdlRegistro($token, $rol_nombre)
    {
        $conectar = parent::Conexion();
        $sql = "insertarRol ?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $rol_nombre);
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
        $sql = "eliminarRol ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->execute();
    }

    //Actualizar registros
    public function mdlActualizarRegistro($rol_nombre, $nuevoToken, $token)
    {
        $conectar = parent::Conexion();
        $sql = "actualizarRol ?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $rol_nombre);
        $query->bindValue(2, $nuevoToken);
        $query->bindValue(3, $token);
        $query->execute();
    }

     //Seleccionar valida acceso
    public function mdlValidarAcceso_rol($token, $identificador)
    {
        $conectar = parent::Conexion();
        $sql = "listamenu03 ?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $identificador);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
