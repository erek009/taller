<?php

class mdlMenu extends Conectar
{

    //Seleccionar registros vehiculo
    public function mdlMenu_x_rol_id($rol)
    {
        $conectar = parent::Conexion();
        $sql = "listamenu01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $rol);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //     public function mdlMenu_x_rol_id($rol)
    // {
    //     $conectar = parent::Conexion();
    //     $sql = "EXEC listamenu01 ?"; 
    //     $query = $conectar->prepare($sql);
    //     $query->bindValue(1, $rol, PDO::PARAM_STR);
    //     $query->execute();
    //     return $query->fetchAll(PDO::FETCH_ASSOC);
    // }

    //habilitar
    public function mdlUpdate_menu_habilitar($detalle_id)
    {
        $conectar = parent::Conexion();
        $sql = "update_menu_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $detalle_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //deshabilitar
    public function mdlUpdate_menu_deshabilitar($detalle_id)
    {
        $conectar = parent::Conexion();
        $sql = "update_menu_02 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $detalle_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

   
}
