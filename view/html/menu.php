<?php
require_once("../../models/mdlMenu.php");
$menu = new mdlMenu();
$datos = $menu->mdlMenu_x_rol_id($_SESSION["rol"]);

?>

<div class="app-menu navbar-menu">

    <div class="navbar-brand-box">

        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="../../assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="../../assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>

        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="../../assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="../../assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>

    </div>

    <div id="scrollbar">

        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span data-key="t-menu">Menu</span></li>


                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Dashboard" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>


                <li class="menu-title"><span data-key="t-menu">Usuarios</span></li>
                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Usuarios" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="menu-title"><span data-key="t-menu">Vehiculos</span></li>
                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Vehiculos" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="menu-title"><span data-key="t-menu">Ordenes</span></li>
                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Ordenes" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>


                <li class="menu-title"><span data-key="t-menu">Servicio</span></li>
                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Servicios" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="menu-title"><span data-key="t-menu">Clientes</span></li>
                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Clientes" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>


                <li class="menu-title"><span data-key="t-menu">Refacciones</span></li>
                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Refacciones" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="menu-title"><span data-key="t-menu">Proveedor</span></li>
                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Proveedor" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>

                <li class="menu-title"><span data-key="t-menu">Compra</span></li>
                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Compra" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>


                <li class="menu-title"><span data-key="t-menu">Venta</span></li>
                <?php
                foreach ($datos as $row) {

                    if ($row["menu_grupo"] == "Venta" && $row["permiso"] == "Si") {
                ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="<?php echo $row["menu_ruta"]; ?>">
                                <i class="ri-honour-line"></i> <span data-key="t-widgets"><?php echo $row["menu_nombre"]; ?></span>
                            </a>
                        </li>
                <?php
                    }
                }
                ?>



            </ul>
        </div>

    </div>

    <div class="sidebar-background"></div>
</div>

<div class="vertical-overlay"></div>