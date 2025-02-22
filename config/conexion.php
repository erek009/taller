<?php
    session_start();
class Conectar
{
    protected $dbh;

    protected function Conexion()
    {
         try {
         $conectar = $this->dbh = new PDO("sqlsrv:Server=ASUS\SQLEXPRESS;Database=taller","sa","mysql12*");
             return $conectar;
         } catch (Exception $e) {
             print "Error conexion BD" . $e->getMessage() . "<br/>";
             die();
        }
    }

    public static function ruta(){
        return "http://localhost/taller2025/";
    }
}




?>