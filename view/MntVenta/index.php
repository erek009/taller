<?php
require_once("../../config/conexion.php");
require_once("../../models/mdlRol.php");
$rol = new mdlRol();
$datos = $rol->mdlValidarAcceso_rol($_SESSION["token"], "Nueva venta");

if (isset($_SESSION["token"])) {
    if (is_array($datos) and count($datos) > 0) {
?>

        <!doctype html>
        <html lang="es" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">

        <head>
            <title>Taller mecanico | Venta</title>

            <?php require_once("../html/head.php"); ?>
        </head>

        <body>

            <div id="layout-wrapper">

                <?php require_once("../html/header.php"); ?>

                <?php require_once("../html/menu.php"); ?>

                <div class="main-content">

                    <div class="page-content">
                        <div class="container-fluid">

                            <!-- ID DE VENTA lo trae de la BD con PA [insertar_venta_01]///// -->
                            <input type="hidden" id="venta_id" name="venta_id" />

                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0">Nueva venta</h4>

                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="javascript: void(0);">Venta</a></li>
                                                <li class="breadcrumb-item active">Nueva venta</li>
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TODO:Datos Proveedor -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Datos del Cliente</h4>
                                        </div>

                                        <div class="card-body">
                                            <div class="live-preview">
                                                <div class="row align-items-center g-3">
                                                    <div class="col-lg-4">
                                                        <label for="cliente_id" class="form-label">Cliente</label>
                                                        <select id="cliente_id" name="cliente_id" class="form-control form-select" aria-label="Seleccione">
                                                            <?php
                                                            echo ' 
                                                        <option value="" disabled selected> Seleccione cliente </option> ';

                                                            include '../../models/mdlCliente.php';

                                                            // Crear instancia del modelo
                                                            $clientes = new mdlCliente();

                                                            // Llamar al método
                                                            $tabla = "clientes";
                                                            $datos = $clientes->mdlSeleccionarRegistros($tabla, null, null);
                                                            ?>

                                                            <?php foreach ($datos as $value): ?>
                                                                <option value="<?= $value['token'] ?>"><?= $value['nombre'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label for="cli_direccion" class="form-label">Dirección</label>
                                                        <input type="text" class="form-control" id="cli_direccion" name="cli_direccion" placeholder="Dirección" readonly />
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <label for="cli_telefono" class="form-label">Telefono</label>
                                                        <input type="text" class="form-control" id="cli_telefono" name="cli_telefono" placeholder="Telefono" readonly />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <!-- TODO:Datos del Producto -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Agregar Producto</h4>
                                        </div>

                                        <div class="card-body">
                                            <div class="live-preview">
                                                <div class="row align-items-center g-3">

                                                    <div class="col-lg-3">
                                                        <label for="categoria" class="form-label">Categoria</label>
                                                        <select id="categoria" name="categoria" class="form-control form-select" aria-label="Seleccione">
                                                            <?php
                                                            echo ' 
                                                        <option value="" disabled selected> Seleccione categoria </option> ';

                                                            include '../../models/mdlCategoria.php';

                                                            // Crear instancia del modelo
                                                            $categoria = new mdlCategoria();

                                                            // Llamar al método
                                                            $tabla = "categoria";
                                                            $datos = $categoria->mdlSeleccionarRegistros($tabla, null, null);
                                                            ?>

                                                            <?php foreach ($datos as $value): ?>
                                                                <option value="<?= $value['token'] ?>"><?= $value['categoria'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>


                                                    <!-- <div class="col-lg-3">
                                                    <label for="producto" class="form-label">Producto</label>
                                                    <select id="producto" name="producto" class="form-control form-select" aria-label="Seleccione">
                                                        <?php
                                                        echo ' 
                                                        <option value="" disabled selected> Seleccione producto </option> ';

                                                        include '../../models/mdlRefaccion.php';

                                                        // Crear instancia del modelo
                                                        $producto = new mdlRefaccion();

                                                        // Llamar al método
                                                        $tabla = "refacciones";
                                                        $datos = $producto->mdlSeleccionarRegistros($tabla, null, null);
                                                        ?>

                                                        <?php foreach ($datos as $value): ?>
                                                            <option value="<?= $value['token'] ?>"><?= $value['nombre'] ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div> -->

                                                    <div class="col-lg-3">
                                                        <label for="producto" class="form-label">Producto</label>
                                                        <select id="producto" name="producto" class="form-control form-select" aria-label="Seleccione">
                                                            <?php
                                                            echo ' 
                                                        <option value="">Seleccione un producto</option>';
                                                            ?>

                                                            <!-- <input type="number" class="form-control" id="precio_compra" name="precio_compra" placeholder="Precio" /> -->
                                                        </select>
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <label for="precio_venta" class="form-label">Precio</label>
                                                        <input type="number" class="form-control" id="precio_venta" name="precio_venta" placeholder="Precio" />
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <label for="stock" class="form-label">Stock</label>
                                                        <input type="text" class="form-control" id="stock" name="stock" placeholder="Stock" readonly />
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <label for="und_nom" class="form-label">UndMedida</label>
                                                        <input type="text" class="form-control" id="und_medida" name="und_medida" placeholder="Und.Medida" readonly />
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <label for="detc_cant" class="form-label">Cantidad</label>
                                                        <input type="number" class="form-control" id="detc_cant" name="detc_cant" placeholder="Cantidad" />
                                                    </div>


                                                    <div class="col-lg-1 d-grid gap-1">
                                                        <label for="comp_cant" class="form-label">&nbsp;</label>
                                                        <button type="button" id="btnagregar" class="btn btn-primary btn-icon waves-effect waves-light"><i class="ri-add-box-line"></i></button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- TODO:Detalle de Compra -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Detalle de compra</h4>
                                        </div>

                                        <div class="card-body">
                                            <table id="table_data" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>Categoria</th>
                                                        <th>Producto</th>
                                                        <th>Und. Medida</th>
                                                        <th>P. Compra</th>
                                                        <th>Cantidad</th>
                                                        <th>Total</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>

                                            <!-- TODO:Calculo Detalle -->
                                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                                <tbody>
                                                    <tr>
                                                        <td>Sub Total</td>
                                                        <td class="text-end" id="precio_subtotal">0</td>
                                                    </tr>
                                                    <tr>
                                                        <td>IVA(16%)</td>
                                                        <td class="text-end" id="precio_iva">0</td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed fs-15">
                                                        <th scope="row">Total</th>
                                                        <th class="text-end" id="precio_total">0</th>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="mt-4">
                                                <label for="comentario" class="form-label text-muted text-uppercase fw-semibold">Comentario</label>
                                                <textarea class="form-control alert alert-info" id="comentario" name="comentario" placeholder="Comentario" rows="4" required=""></textarea>
                                            </div>

                                            <div class="hstack gap-2 left-content-end d-print-none mt-4">
                                                <button type="button" id="btnguardar" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Guardar</button>
                                                <a id="btnlimpiar" class="btn btn-warning"><i class="ri-send-plane-fill align-bottom me-1"></i> Limpiar</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <?php require_once("../html/footer.php"); ?>
            </div>

            </div>

            <?php require_once("../html/js.php"); ?>
            <script type="text/javascript" src="mntventa.js"></script>
        </body>

        </html>
<?php
    } else {
        header("Location:" . Conectar::ruta() . "view/404/");
    }
} else {
    header("Location:" . Conectar::ruta() . "view/404/");
}
?>