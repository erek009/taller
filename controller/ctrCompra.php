<?php
/* TODO: Llamando clases */
require_once("../config/conexion.php");
require_once("../models/mdlCompra.php");

/* TODO: Inicializando clases */
$compra = new mdlCompra();

switch ($_GET["op"]) {
    /*TODO: Guardar y editar, guarda cuando el ID esta vacio y Actualiza cuando se envie el ID*/
    case "registrardetalle":
            $compra->mdlRegistro(
                $_POST["refaccion"],
                $_POST["preciocompra"],
                $_POST["cantidad"]
            );
        break;

    /*TODO: Eliminar (cambia estado a 0 del registro)*/
    // case "eliminar":
    //     $marca->mdlEliminarRegistro($_POST["token"]);
    //     break;
    
}
