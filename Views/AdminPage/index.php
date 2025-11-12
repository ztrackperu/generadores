<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12" id="contenidoPrincipal">
                <!-- CONTENIDO PRINCIPAL-->        
            </div>
        </div>
    </div>
</div>
<!-- MODAL -->
<div class="modal fade" id="modalContenedor" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">Detalles del Contenedor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-12" id="modalContenido">
                        <!-- CONTENIDO-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL ALARMA-->
<div class='modal fade' id='modalAlarma' tabindex='-1' aria-labelledby='my-modal-title' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='title'>ALARMAS</h5>
                <button class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tblAlarma" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Código</th>
                                <th>Alarma</th>
                                <th>Equipo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL MENSAJE-->
<div class='modal fade' id='modalMensaje' tabindex='-1' aria-labelledby='my-modal-title' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='title'>MENSAJES</h5>
                <button class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tblMensaje" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Código</th>
                                <th>Mensaje</th>
                                <th>Equipo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL HORAS -->
<div class='modal fade' id='modalHoras' tabindex='-1' aria-labelledby='my-modal-title' aria-hidden='true'>
    <div class='modal-dialog modal-xl'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='title'>HORAS</h5>
                <button class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <div class="table-responsive">
                    <table class="table table-bordered" id="tblHoras" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Desde</th>
                                <th>Hora actual</th>
                                <th>Duración</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>