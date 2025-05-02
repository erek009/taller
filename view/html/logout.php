<?php
    require_once("../../config/conexion.php");
    session_destroy();

    echo '<script>window.location = "../../index.php"; </script>';
    exit();
?>