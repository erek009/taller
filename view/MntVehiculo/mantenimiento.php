<div id="modalmantenimiento" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <!-- TODO:Formulario de Mantenimiento -->
            <form method="post" id="mantenimiento_form">
                <div class="modal-body">
                    <input type="hidden" name="token" id="token" />

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Tipo Vehiculo</label>
                                <select id="tipo" class="form-control" name="tipo">
                                    <?php
                                    echo ' 
                                            <option value="" disabled selected>Seleccione tipo vehiculo </option> 
                                        <option>Automovil</option>
                                        <option>Camioneta</option>
                                        <option>Tractor</option>';
                                    ?>
                                </select>
                                <span class="text-danger" id="tipohelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Placa</label>
                                <input type="text" class="form-control" id="placa" name="placa" required />
                                <span class="text-danger" id="placahelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Marca</label>
                                <select id="marca" class="form-control" name="marca">
                                    <?php
                                    echo ' 
                                    <option value="" disabled selected> Seleccione marca </option> ';

                                    include '../../models/mdlMarca.php';

                                    // Crear instancia del modelo
                                    $marca = new mdlMarca();

                                    // Llamar al método
                                    $tabla = "marca";
                                    $datos = $marca->mdlSeleccionarRegistros($tabla, null, null);
                                    ?>

                                    <?php foreach ($datos as $value): ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['marca'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <span class="text-danger" id="marcahelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo" required />
                                <span class="text-danger" id="modeloHelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Año</label>
                                <select id="ano" class="form-control" name="ano">
                                    <?php
                                    echo ' 
                                    <option value="" disabled selected> Seleccione año </option> ';

                                    include '../../models/mdlAnoVehiculo.php';

                                    // Crear instancia del modelo
                                    $ano = new mdlAnoVehiculo();

                                    // Llamar al método
                                    $tabla = "ano";
                                    $datos = $ano->mdlSeleccionarRegistros($tabla, null, null);
                                    ?>

                                    <!-- <select> -->
                                    <?php foreach ($datos as $value): ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['ano'] ?></option>
                                    <?php endforeach; ?>
                                    <!-- </select> -->
                                </select>

                                <span class="text-danger" id="anohelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">No. VIN</label>
                                <input type="text" class="form-control" id="vin" name="vin" required />
                                <span class="text-danger" id="vinhelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Color</label>
                                <input type="text" class="form-control" id="color" name="color" required />
                                <span class="text-danger" id="colorhelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Cliente</label>
                                <select id="cliente" class="form-control" name="cliente">
                                    <?php
                                    echo ' 
                                     <option value="" disabled selected> Seleccione cliente </option> ';

                                    include '../../models/mdlCliente.php';

                                    // Crear instancia del modelo
                                    $cliente = new mdlAnoVehiculo();

                                    // Llamar al método
                                    $tabla = "clientes";
                                    $datos = $cliente->mdlSeleccionarRegistros($tabla, null, null);
                                    ?>

                                    <!-- <select> -->
                                    <?php foreach ($datos as $value): ?>
                                        <option value="<?= $value['id'] ?>"><?= $value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                    <!-- </select> -->
                                </select>

                                <span class="text-danger" id="clientehelp"> </span>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" value="add" class="btn btn-primary ">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>