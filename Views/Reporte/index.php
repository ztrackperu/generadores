<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Reporte General por día</h5>
                        <div class="text-center">
                            <form id="frmReporte" onsubmit="reporteGeneral(event)">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <label for="f_busqueda">Seleccione una fecha:</label>
                                        <input type="date" class="form-control" id="f_busqueda" name="f_busqueda">
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group">
                                        <button class="btn btn-primary mt-4 w-100" type="submit">Buscar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>