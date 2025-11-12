<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <!--CONTENEDOR -->
                        <form id="frmData" onsubmit="buscarData(event)">
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
                        <h1 class="fw-bold fs-4" id="titleData"></h1>
                        <div class="table-responsive mt-5">
                            <table class="table table-bordered table-hover" style="width:100%; font-size:12px;" id="tblDatos2">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Voltaje de batería</th>
                                        <th>Temp. motor</th>
                                        <th>Frecuencia de arranque</th>
                                        <th>Nivel de combustible</th>
                                        <th>Voltaje entregado</th>
                                        <th>Corriente del rotor</th>
                                        <th>Corriente de campo</th>
                                        <th>Eco power</th>
                                        <th>RPM</th>
                                        <th>Horómetro</th>
                                        <th>Modelo</th>
                                        <th>Alarma</th>
                                        <th>Evento</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí irán tus filas de datos -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>