<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body py-5">
                        <h5 class="card-title text-center text-uppercase">Alarmas</h5>
                        <div class="d-flex justify-content-between py-1">
                            <button type="button" class="btn btn-success rounded-circle" onclick="frmAlarma()"><i class="ri-add-circle-fill"></i></button>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="tblAlarmas">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>CODIGO</th>
                                            <th>NOMBRE</th>
                                            <th>CAUSA</th>
                                            <th>DIAGNOSTICO</th>
                                            <th>ACCIONES</th>
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
</div>
<!-- AGREGAR Y EDITAR ALARMA -->
<div class="modal fade" id="modalAgregarYeditarAlarma" tabindex="-1" aria-labelledby="modalAgregarYeditarAlarma" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title text-white" id="title">Registro Alarma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmAlarma" onsubmit="registrarAlarma(event)">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <div class="mt-2">
                                    <label for="codigo">Código</label>
                                    <input type="hidden" id="id" name="id">
                                    <input id="codigo" class="form-control" type="text" name="codigo" required placeholder="Código de Alarma" required>
                                </div>
                                <div class="mt-2">
                                    <label for="nombre">Nombre</label>
                                    <input id="nombre" class="form-control" type="text" name="nombre" required placeholder="Nombre" required>
                                </div>
                                <div class="mt-2">
                                    <label for="tipo_causa">Tipo o Causa</label>
                                    <input id="tipo_causa" class="form-control" type="text" name="tipo_causa" required placeholder="Tipo o causa" required>
                                </div>
                                <div class="mt-2">
                                    <label for="diagnostico">Diagnóstico</label>
                                    <input id="diagnostico" class="form-control" type="text" name="diagnostico" required placeholder="Diagnóstico" required>
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
<!--MODAL VER DETALLES DE ALARMA-->
<div class="modal fade" id="modalVerAlarma" tabindex="-1" aria-labelledby="modalVerAlarmaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">Detalles de Alarma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-12" id="viewAlarma">
                        <!-- CONTENIDO VIEW-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
<!-- MODAL PARA ELIMINAR ALARMA-->
<div class="modal fade" id="modalEliminarAlarma" tabindex="-1" aria-labelledby="modalEliminarAlarmaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Eliminar Alarma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-12" id="deleteAlarma">
                        <!-- CONTENIDO DELETE-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>