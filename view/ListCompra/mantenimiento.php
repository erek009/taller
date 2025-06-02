<div id="modaldetalle" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <!-- TODO:Formulario de Mantenimiento -->
            <div class="modal-body">
                <table id="detalle_data" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Categoria</th>
                            <th>Producto</th>
                            <th>Unidad</th>
                            <th>P. Compra</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

                <!-- TODO: Calculo de Compra -->
                <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                    <tbody>
                        <tr>
                            <td>Sub Total</td>
                            <td class="text-end" id="precio_subtotal">0</td>
                        </tr>
                        <tr>
                            <td>IGV (18%)</td>
                            <td class="text-end" id="precio_iva">0</td>
                        </tr>
                        <tr class="border-top border-top-dashed fs-15">
                            <th scope="row">Total</th>
                            <th class="text-end" id="precio_total">0</th>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>