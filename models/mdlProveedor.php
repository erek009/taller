<?php

class mdlProveedor extends Conectar
{

    //Registrar
    public function mdlRegistro($token, $razonsocial, $rfc, $telefono, $email)
    {
        $conectar = parent::Conexion();
        $sql = "insertarProveedor ?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $razonsocial);
        $query->bindValue(3, $rfc);
        $query->bindValue(4, $telefono);
        $query->bindValue(5, $email);
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
        $sql = "eliminarProveedor ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->execute();
    }

    //Actualizar registros
    public function mdlActualizarRegistro($razonsocial, $rfc, $telefono, $email, $nuevoToken, $token)
    {
        $conectar = parent::Conexion();
        $sql = "actualizarProveedor ?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $razonsocial);
        $query->bindValue(2, $rfc);
        $query->bindValue(3, $telefono);
        $query->bindValue(4, $email);
        $query->bindValue(5, $nuevoToken);
        $query->bindValue(6, $token);
        $query->execute();
    }
}
