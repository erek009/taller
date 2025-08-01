<div id="modalmantenimiento" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="lbltitulo"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulario de Mantenimiento -->
            <form method="post" id="mantenimiento_form">
                <div class="modal-body">
                    <input type="hidden" name="token" id="token" />

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Refaccion</label>
                                <select id="refaccion" class="form-control" name="refaccion">
                                    <?php
                                    echo ' 
                                    <option value="" disabled selected> Seleccione refaccion </option> ';

                                    include_once '../../models/mdlRefaccion.php';

                                    // Crear instancia del modelo
                                    $refaccion = new mdlRefaccion();

                                    // Llamar al método
                                    $tabla = "refacciones";
                                    $datos = $refaccion->mdlSeleccionarRegistros($tabla, null, null);
                                    ?>

                                    <?php foreach ($datos as $value): ?>
                                        <option value="<?= $value['token'] ?>"><?= $value['nombre'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                                <span class="text-danger" id="refaccionhelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label for="codigos" class="form-label">Códigos de barras (uno por línea)</label>
                        <textarea
                            class="form-control"
                            name="codigo"
                            id="codigo"
                            rows="5"
                            placeholder="Ejemplo:
                                7501055312345
                                7501055312346"
                            required></textarea>
                        <span class="text-danger" id="codigoshelp"></span>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" value="add" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>