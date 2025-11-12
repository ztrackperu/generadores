<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body py-5">
                    <h5 class="card-title text-center text-uppercase">Mantenimientos</h5>
                    <div class="d-flex justify-content-between py-1">
                        <button type="button" class="btn btn-sm btn-success" onclick="frmMantenimiento()"><i class="ri-add-circle-fill"></i></button>
                    </div>
                      <div class="table-responsive">
                        <table class="table table-bordered text-center" id="tblMantenimiento" style="width:100%; font-size:12px;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Dispositivo</th>
                                    <th>Último horómetro</th>
                                    <th>Fecha último mantenimiento</th>
                                    <th>Próximo mantenimiento</th>
                                    <th>Tipo</th>
                                    <th>Acciones</th>
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
<div class="modal fade" id="modalAgregarYEditarMantenimiento" tabindex="-1" aria-labelledby="modalAgregarYEditarMantenimiento" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title text-white" id="title">Registrar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmMantenimiento" onsubmit="registrarMantenimiento(event)">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <div class="mt-2">
                                    <label for="dispositivo">Dispositivo</label>
                                    <input type="hidden" id="id" name="id">
                                    <select id="dispositivo" class="form-select" name="dispositivo" required>
                                        <!--contenido-->
                                    </select>
                                </div>
                                <div class="mt-2">
                                    <label for="horometro">Horómetro actual</label>
                                    <input id="horometro" class="form-control" type="number" min="0" name="horometro" required placeholder="Horómetro" required>
                                </div>
                                <div class="mt-2">
                                    <label for="tipo">Tipo</label>
                                    <select id="tipo" class="form-select" name="tipo" required>
                                        <option value="">Seleccione</option>
                                        <option value="M1">M1</option>
                                        <option value="M2">M2</option>
                                        <option value="M3">M3</option>
                                        <option value="M4">M4</option>
                                    </select>   
                                </div>
                                <!--datetime local -->
                                <div class="mt-2">
                                    <label for="fecha_prx_mantenimiento">Fecha</label>
                                    <input id="fecha_prx_mantenimiento" class="form-control" type="datetime-local" name="fecha_prx_mantenimiento" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-2">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
                                <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Atras</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalHistorico" tabindex="-1" aria-labelledby="modalHistorico" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title text-white" id="title">Histórico de Mantenimientos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="tblHistorico" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Dispositivo</th>
                                <th>Horómetro</th>
                                <th>Tipo</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalInsercionMasiva" tabindex="-1" aria-labelledby="modalInsercionMasiva">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title text-white" id="title">Lista de Dispositivos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmDispositivos" onsubmit="grabarDispositivos(event)">
                    <div id="contenido">
                        <!-- dispositivos -->  
                    </div>
                   
                </form>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>