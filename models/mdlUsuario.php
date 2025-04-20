<?php

class mdlUsuario extends Conectar
{

    //Registrar usuario
    public function mdlRegistro($token, $nombre, $correo, $pass)
    {
        $conectar = parent::Conexion();
        $sql = "insertarUsuario ?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $nombre);
        $query->bindValue(3, $correo);
        $query->bindValue(4, $pass);
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
        $sql = "eliminarUsuario ?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->execute();
    }

    //Actualizar registros
    public function mdlActualizarRegistro($nombre, $correo, $password, $nuevoToken, $token)
    {
        $conectar = parent::Conexion();
        $sql = "actualizarUsuario ?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $nombre);
        $query->bindValue(2, $correo);
        $query->bindValue(3, $password);
        $query->bindValue(4, $nuevoToken);
        $query->bindValue(5, $token);
        $query->execute();
    }




    /* TODO:Acceso al Sistema */
    public function login()
    {
        $conectar = parent::Conexion();
        if (isset($_POST["enviar"])) {
            /* TODO: Recepcion de Parametros desde la Vista Login */

            $correo = $_POST["ingresoEmail"];
            $pass = crypt($_POST["ingresoPassword"], '$2a$07$Plu590nEp1uS9Pr0hA55elBAd$');

            if (empty($correo) and empty($pass)) {
                exit();
            } else {
                $sql = "seleccionarUsuario ?,?";
                $query = $conectar->prepare($sql);
                $query->bindValue(1, $correo);
                $query->bindValue(2, $pass);
                $query->execute();
                $resultado = $query->fetch();
                if (is_array($resultado) and count($resultado) > 0) {
                    /* TODO:Generar variables de Session del Usuario */

                    $_SESSION["id"] = $resultado["id"];
                    $_SESSION["nombre"] = $resultado["nombre"];

                    header("Location:" . Conectar::ruta() . "view/home/");
                } else {
                    header("Location:" . Conectar::ruta() . "/index.php");
                    exit();
                }
            }
        } else {
            exit();
        }
    }
}
