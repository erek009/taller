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
                                <label for="valueInput" class="form-label">Buscar placa vehiculo</label>
                                <select id="vehiculo" class="form-control" name="vehiculo">
                                    <?php
                                    echo ' 
                                    <option value="" disabled selected> Seleccione vehiculo </option> ';

                                    include '../../models/mdlVehiculo.php';

                                    // Crear instancia del modelo
                                    $vehiculo = new mdlVehiculo();

                                    // Llamar al método
                                    $tabla = "vehiculo";
                                    $datos = $vehiculo->mdlSeleccionarRegistros($tabla, null, null);
                                    ?>

                                    <?php foreach ($datos as $value): ?>
                                        <option value="<?= $value['token'] ?>"><?= $value['placa'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <span class="text-danger" id="vehiculohelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Concepto</label>
                                <select id="concepto" class="form-control" name="concepto">
                                    <?php
                                    echo ' 
                                            <option value="" disabled selected>Seleccione concepto </option> 
                                        <option>Reparacion</option>
                                        <option>Servicio</option>
                                        <option>Mantenimiento</option>
                                        <option>Revision</option>
                                        <option>Garantia</option>
                                        <option>Otros</option>';
                                    ?>
                                </select>
                                <span class="text-danger" id="conceptohelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Nivel Combustible</label>
                                <select id="combustible" class="form-control" name="combustible">
                                    <?php
                                    echo ' 
                                            <option value="" disabled selected>Nivel de combustible </option> 
                                        <option>Bajo</option>
                                        <option>1/4</option>
                                        <option>1/2</option>
                                        <option>3/4</option>
                                        <option>Lleno</option>
                                        <option>No funciona</option>';
                                    ?>
                                </select>
                                <span class="text-danger" id="combustiblehelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Kilometros</label>
                                <input type="text" class="form-control" id="kilometros" name="kilometros" required />
                                <span class="text-danger" id="kilometroshelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Nombre tecnico</label>
                                <select id="tecnico" class="form-control" name="tecnico">
                                    <?php
                                    echo ' 
                                    <option value="" disabled selected> Seleccione tecnico </option> ';

                                    include '../../models/mdlUsuario.php';

                                    // Crear instancia del modelo
                                    $usuario = new mdlUsuario();

                                    // Llamar al método
                                    $tabla = "usuarios";
                                    $datos = $usuario->mdlSeleccionarRegistros($tabla, null, null);
                                    ?>

                                    <?php foreach ($datos as $value): ?>
                                        <option value="<?= $value['token'] ?>"><?= $value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <span class="text-danger" id="tecnicohelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Servicio</label>
                                <select id="servicio" class="form-control" name="servicio">
                                    <?php
                                    echo ' 
                                    <option value="" disabled selected> Seleccione servicio </option> ';

                                    include '../../models/mdlServicio.php';

                                    // Crear instancia del modelo
                                    $servicio = new mdlServicio();

                                    // Llamar al método
                                    $tabla = "servicio";
                                    $datos = $servicio->mdlSeleccionarRegistros($tabla, null, null);
                                    ?>

                                    <?php foreach ($datos as $value): ?>
                                        <option value="<?= $value['token'] ?>"><?= $value['nombreservicio'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <span class="text-danger" id="serviciohelper"> </span>
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