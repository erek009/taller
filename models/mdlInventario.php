<?php 

class mdlInventario extends Conectar{

    //Registrar refaccion
    public function mdlRegistro($nombre,$direccion,$telefono,$usuario){
        $conectar=parent::Conexion();
        $sql="insertarInventario ?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $nombre);
        $query->bindValue(2, $direccion);
        $query->bindValue(3, $telefono);
        $query->bindValue(3, $usuario);
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

}


?>