<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body py-5">
                        <h5 class="card-title text-center text-uppercase">GPS</h5>
                        <form id="frmGps" onsubmit="buscarGps(event)">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <label for="dispositivos">Dispositivos</label>
                                    <select class="form-select" id="dispositivos" name="dispositivos" onchange="seleccionarGenset(this.value)">
                                        <!--contenido-->
                                    </select>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="f_inicio">Inicio</label>
                                    <input type="datetime-local" class="form-control" id="f_inicio" name="f_inicio">  
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label for="f_fin">Fin</label>
                                    <input type="datetime-local" class="form-control" id="f_fin" name="f_fin">
                                </div>
                                <div class="col-12 col-lg-3">
                                    <button class="btn btn-primary mt-4 w-100" type="submit">Buscar</button>
                                </div>
                            </div>
                        </form>
                        <div id="mapa-container" class="mt-4">
                            <div class='mt-4' id='mapa' style='height: 800px;'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>