<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body py-5">
                        <h5 class="card-title text-center text-uppercase">Alertas</h5>
                        <form id="frmAlertas" onsubmit="buscarAlerta(event)">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="f_inicio">Inicio</label>
                                        <input type="datetime-local" class="form-control" id="f_inicio" name="f_inicio">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <label for="f_fin">Fin</label>
                                        <input type="datetime-local" class="form-control" id="f_fin" name="f_fin">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <button class="btn btn-primary mt-4 w-100" type="submit">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive mt-4">
                            <table class="table table-bordered text-center" id="tblAlertas">
                                <thead>
                                    <tr>
                                        <th>Generador</th>
                                        <th>Fecha</th>
                                        <th>Código</th>
                                        <th>Detalle</th>
                                        <th>Tipo</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL DEFINICION DE CODIGO -->
<div class="modal fade" id="modalDefCodigo" tabindex="-1" aria-labelledby="modalDefCodigo" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">DEFINICIÓN DE CÓDIGO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-12" id="contentDefCodigo">
                        <!-- CONTENIDO-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>