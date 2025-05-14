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
                                <label for="valueInput" class="form-label">Nombre/RazonSocial</label>
                                <input type="text" class="form-control" id="razonsocial" name="razonsocial" required />
                                <span class="text-danger" id="razonsocialhelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">RFC</label>
                                <input type="text" class="form-control" id="rfc" name="rfc" required />
                                <span class="text-danger" id="rfchelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Direccion</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" required />
                                <span class="text-danger" id="direccionhelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Telefono</label>
                                <input type="number" class="form-control" id="telefono" name="telefono" required />
                                <span class="text-danger" id="telefonohelper"> </span>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-2">
                        <div class="col-md-12">
                            <div>
                                <label for="valueInput" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required />
                                <span class="text-danger" id="emailhelper"> </span>
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