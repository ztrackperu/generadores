<?php include "Views/templates/navbar.php"; ?>

<div class="px-3 py-3">
    <!-- TABS -->
    <ul class="nav nav-tabs mb-3" id="tabCatalogos">
        <li class="nav-item">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabAlarmas">
                <i class="bi bi-bell-fill text-danger me-1"></i> Alarmas
            </button>
        </li>
        <li class="nav-item">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabMensajes">
                <i class="bi bi-chat-fill text-warning me-1"></i> Mensajes
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <!-- TAB ALARMAS -->
        <div class="tab-pane fade show active" id="tabAlarmas">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-bell-fill text-danger me-2"></i>Catálogo de Alarmas</h5>
                    <button class="btn btn-primary btn-sm" onclick="nuevaAlarma()">
                        <i class="bi bi-plus-lg me-1"></i> Nueva Alarma
                    </button>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tblAlarmas" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB MENSAJES -->
        <div class="tab-pane fade" id="tabMensajes">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-chat-fill text-warning me-2"></i>Catálogo de Mensajes</h5>
                    <button class="btn btn-primary btn-sm" onclick="nuevoMensaje()">
                        <i class="bi bi-plus-lg me-1"></i> Nuevo Mensaje
                    </button>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="tblMensajes" width="100%">
                        <thead class="table-dark">
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Estado</th>
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

<!-- MODAL DETALLE/EDITAR (compartido) -->
<div class="modal fade" id="modalCatalogo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="modalCatalogoTitulo">Detalle</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="frmCatalogo">
                    <input type="hidden" id="cat_id"   name="id">
                    <input type="hidden" id="cat_tipo" name="tipo"> <!-- alarma | mensaje -->
                    <div class="row g-3">
                        <div class="col-12 col-md-2">
                            <label class="form-label fw-bold">Código</label>
                            <input type="number" class="form-control" id="cat_codigo" name="codigo" required>
                        </div>
                        <div class="col-12 col-md-10">
                            <label class="form-label fw-bold">Nombre</label>
                            <input type="text" class="form-control" id="cat_nombre" name="nombre" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Tipo / Causa</label>
                            <textarea class="form-control" id="cat_tipo_causa" name="tipo_causa" rows="3"></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Diagnóstico</label>
                            <textarea class="form-control" id="cat_diagnostico" name="diagnostico" rows="4"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="btnGuardarCatalogo" onclick="guardarCatalogo()">
                    <i class="bi bi-save me-1"></i> Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>

<script src="<?php echo base_url; ?>Assets/js/Catalogos.js"></script>