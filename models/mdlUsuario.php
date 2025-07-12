<?php

class mdlUsuario extends Conectar
{

    //Registrar usuario
    public function mdlRegistro($token, $nombre, $correo, $pass, $rol, $usu_img)
    {
        $conectar = parent::Conexion();

        //sube la imagen del producto
        require_once("mdlUsuario.php");
        $usuario = new mdlUsuario();
        $usu_img = '';
        if ($_FILES["usu_img"]["name"] != '') {
            $usu_img = $usuario->guardar_imagen();
        }
        
        $sql = "insertarUsuario ?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $token);
        $query->bindValue(2, $nombre);
        $query->bindValue(3, $correo);
        $query->bindValue(4, $pass);
        $query->bindValue(5, $rol);
        $query->bindValue(6, $usu_img);
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

    //Seleccionar registros vehiculo
    public function mdlSeleccionarRegistrosUsuario($tabla, $item, $valor)
    {
        $conectar = parent::Conexion();
        $sql = "seleccionarRegistroUsuario";
        $query = $conectar->prepare($sql);
        // $query->bindValue(1, $tabla);
        // $query->bindValue(1, $item);
        // $query->bindValue(1, $valor);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
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
    public function mdlActualizarRegistro($nombre, $correo, $password, $rol, $usu_img, $nuevoToken, $token)
    {
        $conectar = parent::Conexion();
         //sube la imagen del producto
        require_once("mdlUsuario.php");
        $usuario = new mdlUsuario();
        $usu_img = '';
        if ($_FILES["usu_img"]["name"] != '') {
            $usu_img = $usuario->guardar_imagen();
         } else {
            $usu_img = $POST["hidden_usuario_imagen"];
        }

        $sql = "actualizarUsuario ?,?,?,?,?,?,?";
        $query = $conectar->prepare($sql);
        $query->bindValue(1, $nombre);
        $query->bindValue(2, $correo);
        $query->bindValue(3, $password);
        $query->bindValue(4, $rol);
        $query->bindValue(5, $usu_img);
        $query->bindValue(6, $nuevoToken);
        $query->bindValue(7, $token);
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

                    // $_SESSION["id"] = $resultado["id"];
                    $_SESSION["token"] = $resultado["token"];
                    $_SESSION["nombre"] = $resultado["nombre"];
                    $_SESSION["usu_img"] = $resultado["usu_img"];
                    $_SESSION["rol"] = $resultado["rol"];


                    header("Location:" . Conectar::ruta() . "view/home/");
                } else {
                    // header("Location:" . Conectar::ruta() . "/index.php");
                        echo "<script>
                            alert('Usuario o contraseña incorrectos.');
                            window.location.href = '" . Conectar::ruta() . "/index.php';
                            </script>";
                    exit();
                    }
                }
             } else {
            exit();
        }
    }

    /* TODO: Registrar Imagen */
    public function guardar_imagen()
    {
        if (isset($_FILES["usu_img"])) {
            $extension = explode('.', $_FILES['usu_img']['name']);
            $new_name = rand() . '.' . $extension[1];
            $destination = '../assets/usuario/' . $new_name;
            move_uploaded_file($_FILES['usu_img']['tmp_name'], $destination);
            return $new_name;
        }
    }

}
