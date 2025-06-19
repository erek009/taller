<?php
    // require_once("../../models/Menu.php");
    // $menu = new Menu();
    // $datos = $menu->get_menu_x_rol_id($_SESSION["ROL_ID"]);
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
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../home/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Dashboard</span>
                        </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Usuarios</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntUsuario/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Usuarios</span>
                        </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Vehiculos</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntVehiculo/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Vehiculos</span>
                        </a>
                </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntAno/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Año</span>
                        </a>
                </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntMarca/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Marcas</span>
                        </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Ordenes</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntOrden/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Ordenes</span>
                        </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Servicio</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntServicio/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Servicio</span>
                        </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Clientes</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntCliente/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Clientes</span>
                        </a>
                </li>

                <li class="menu-title"><span data-key="t-menu">Refacciones</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntRefaccion/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Refacciones</span>
                        </a>
                </li>

                <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntCategoria">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Categoria</span>
                        </a>
                </li>


                <li class="menu-title"><span data-key="t-menu">Proveedor</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntProveedor/">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Proveedor</span>
                        </a>
                </li>


                <li class="menu-title"><span data-key="t-menu">Compra</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntCompra">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Nueva compra</span>
                        </a>
                </li>
                <li class="nav-item">
                        <a class="nav-link menu-link" href="../ListCompra">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Lista compra</span>
                        </a>
                </li>


                <li class="menu-title"><span data-key="t-menu">Venta</span></li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="../MntVenta">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Nueva venta</span>
                        </a>
                </li>
                <li class="nav-item">
                        <a class="nav-link menu-link" href="../ListVenta">
                        <i class="ri-honour-line"></i> <span data-key="t-widgets">Lista venta</span>
                        </a>
                </li>




            </ul>
        </div>

    </div>

    <div class="sidebar-background"></div>
</div>

<div class="vertical-overlay"></div>