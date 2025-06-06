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
                    <input type="hidden" name="token" id="token"/>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Codigo</label>
                                <input type="text" class="form-control" id="codigo" name="codigo" required/>
                                <span class="text-danger" id="codigohelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Categoria</label>
                                <select id="categoria" class="form-control" name="categoria">
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
                                <span class="text-danger" id="categoriahelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Nombre producto</label>
                                <input type="text" class="form-control" id="nombreproducto" name="nombreproducto" required />
                                <span class="text-danger" id="nombrehelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Unidad de medida</label>
                                <select id="unidadmedida" class="form-control" name="unidadmedida">
                                    <?php
                                    echo ' 
                                        <option value="" disabled selected>Unidad de medida </option> 
                                        <option>Unidad</option>
                                        <option>Garrafa</option>
                                        <option>Litro</option>';
                                    ?>
                                </select>
                                <span class="text-danger" id="medidahelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Marca</label>
                                <input type="text" class="form-control" id="marca" name="marca" required />
                                <span class="text-danger" id="marcahelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock" required />
                                <span class="text-danger" id="stockhelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Precio compra</label>
                                <input type="number" class="form-control" id="preciocompra" name="preciocompra" required />
                                <span class="text-danger" id="comprahelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Precio venta</label>
                                <input type="number" class="form-control" id="precioventa" name="precioventa" required />
                                <span class="text-danger" id="ventahelp"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Descripcion</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion" required />
                                <span class="text-danger" id="descripcionhelp"> </span>
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