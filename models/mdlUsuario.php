<?php 

class mdlUsuario extends Conectar{

    //Registrar usuario
    public function mdlRegistro($token,$nombre,$correo,$password){
        $conectar=parent::Conexion();
        $sql="insertarUsuario ?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $nombre);
        $query->bindValue(3, $correo);
        $query->bindValue(4, $password);
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
         $sql="eliminarUsuario ?";
         $query = $conectar->prepare($sql);
         $query->bindValue(1, $token);
         $query->execute();
     }

    //Actualizar registros
    public function mdlActualizarRegistro($nombre,$correo,$password,$nuevoToken,$token){
        $conectar = parent::Conexion();
        $sql = "actualizarTelefono ?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $nombre);
        $query->bindValue(2, $correo);
        $query->bindValue(3, $password);
        $query->bindValue(4, $nuevoToken);
        $query->bindValue(5, $token);
        $query->execute();
    }




    /* TODO:Acceso al Sistema */
    public function login(){
        $conectar=parent::Conexion();
        if (isset($_POST["enviar"])){
            /* TODO: Recepcion de Parametros desde la Vista Login */

            $correo = $_POST["ingresoEmail"];
            $pass = crypt($_POST["ingresoPassword"], '$2a$07$Plu590nEp1uS9Pr0hA55elBAd$');

            // var_dump($pass);
            // exit;

            if (empty($correo) and empty($pass)){
                exit();
            }else{
                $sql="seleccionarUsuario ?,?";
                $query=$conectar->prepare($sql);
                $query->bindValue(1,$correo);
                $query->bindValue(2,$pass);
                $query->execute();
                $resultado = $query->fetch();
                if (is_array($resultado) and count($resultado)>0){
                    /* TODO:Generar variables de Session del Usuario */
                    // $_SESSION["USU_ID"]=$resultado["USU_ID"];

                    header("Location:".Conectar::ruta()."view/home/");
                }else{
                    exit();
                }
            }
        }else{
            exit();
        }
    }


}
?>