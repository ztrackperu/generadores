<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body py-5">
                        <h5 class="card-title text-center text-uppercase">Perfiles</h5>
                        <div class="d-flex justify-content-between py-1">
                            <button type="button" class="btn btn-success rounded-circle" onclick="frmPerfil()"><i class="ri-add-circle-fill"></i></button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" id="tblPerfiles" width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Usuario</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Correo</th>
                                        <th>RUC</th>
                                        <th>Empresa</th>
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
<!-- AGREGAR Y EDITAR Perfil -->
<div class="modal fade" id="modalAgregarYeditarPerfil" tabindex="-1" aria-labelledby="modalAgregarYeditarPerfil" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title text-white" id="title">Registro Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="frmPerfil" onsubmit="registrarPerfil(event)">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <div class="form-group">
                                <div class="mt-2">
                                    <label for="usuario">Usuario</label>
                                    <input type="hidden" id="id" name="id">
                                    <input id="usuario" class="form-control" type="text" name="usuario" required placeholder="Usuario" required>
                                </div>
                                <div class="mt-2">
                                    <label for="nombre">Nombre</label>
                                    <input id="nombre" class="form-control" type="text" name="nombre" required placeholder="Nombre" required>
                                </div>
                                <div class="mt-2">
                                    <label for="apellido">Apellido</label>
                                    <input id="apellido" class="form-control" type="text" name="apellido" required placeholder="Apellido" required>
                                </div>
                                <div class="mt-2">
                                    <label for="correo">Correo</label>
                                    <input id="correo" class="form-control" type="text" name="correo" required placeholder="Correo" required>
                                </div>
                                <div class="mt-2">
                                    <label for="ruc">RUC</label>
                                    <input id="ruc" class="form-control" type="text" name="ruc" required placeholder="RUC" required>
                                </div>
                                <div class="mt-2">
                                    <label for="empresa">Empresa</label>
                                    <input id="empresa" class="form-control" type="text" name="empresa" required placeholder="Empresa" required>
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
<!--MODAL VER DETALLES DE Perfil-->
<div class="modal fade" id="modalVerPerfil" tabindex="-1" aria-labelledby="modalVerPerfilLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <h5 class="modal-title">Detalles de Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-12" id="viewPerfil">
                        <!-- CONTENIDO VIEW-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
<!-- MODAL PARA ELIMINAR Perfil-->
<div class="modal fade" id="modalEliminarPerfil" tabindex="-1" aria-labelledby="modalEliminarPerfilLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Eliminar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 col-lg-12" id="deletePerfil">
                        <!-- CONTENIDO DELETE-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>