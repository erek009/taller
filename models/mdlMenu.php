<?php

class mdlMenu extends Conectar
{

    //Lista roles
    public function mdlMenu_x_rol_id($rol)
    {
        $conectar = parent::Conexion();
        $sql = "listamenu01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $rol);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //Agrega nuevos menus por ROL
         public function mdlInserMenu02($rol)
     {
         $conectar = parent::Conexion();
        $sql = "InserMenu02 ?"; 
         $query = $conectar->prepare($sql);
        $query->bindValue(1, $rol);
         $query->execute();
         return $query->fetchAll(PDO::FETCH_ASSOC);
     }

    //habilita menu
    public function mdlUpdate_menu_habilitar($detalle_id)
    {
        $conectar = parent::Conexion();
        $sql = "update_menu_01 ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $detalle_id);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    //deshabilita menu
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
