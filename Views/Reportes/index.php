<?php include "Views/templates/navbar.php"; ?>

<div class="px-3 py-3">
    <div class="card mb-3">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0"><i class="bi bi-file-earmark-bar-graph me-2"></i>Reporte Operacional</h5>
        </div>
        <div class="card-body">
            <form id="frmReporte">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-lg-3">
                        <label class="form-label fw-bold">Dispositivo</label>
                        <select class="form-select" id="sel_imei" name="imei">
                            <option value="">Cargando...</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-2">
                        <label class="form-label fw-bold">Agrupación</label>
                        <select class="form-select" id="sel_agrupacion" name="agrupacion">
                            <option value="dia">Por día</option>
                            <option value="semana">Por semana</option>
                            <option value="mes">Por mes</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-3">
                        <label class="form-label fw-bold">Fecha inicio</label>
                        <input type="datetime-local" class="form-control" id="f_inicio" name="f_inicio">
                    </div>
                    <div class="col-12 col-lg-3">
                        <label class="form-label fw-bold">Fecha fin</label>
                        <input type="datetime-local" class="form-control" id="f_fin" name="f_fin">
                    </div>
                    <div class="col-12 col-lg-1">
                        <button type="button" class="btn btn-primary w-100" onclick="generarReporte()">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- RESUMEN CARDS -->
    <div class="row g-3 mb-3" id="cardsResumen" style="display:none!important;">
        <div class="col-6 col-lg-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="bi bi-clock-history fs-2 text-primary"></i>
                    <h6 class="text-uppercase mt-1">Horas operación</h6>
                    <h3 class="fw-bold" id="totalHorasOp">0</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-danger">
                <div class="card-body text-center">
                    <i class="bi bi-lightning-fill fs-2 text-danger"></i>
                    <h6 class="text-uppercase mt-1">Horas Full (≥55Hz)</h6>
                    <h3 class="fw-bold" id="totalHorasFull">0</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="bi bi-leaf fs-2 text-success"></i>
                    <h6 class="text-uppercase mt-1">Horas Eco (&lt;55Hz)</h6>
                    <h3 class="fw-bold" id="totalHorasEco">0</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="bi bi-fuel-pump fs-2 text-warning"></i>
                    <h6 class="text-uppercase mt-1">Consumo total</h6>
                    <h3 class="fw-bold" id="totalConsumo">0 L</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLA DETALLE -->
    <div class="card" id="cardTabla" style="display:none;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0 fw-bold" id="tituloTabla">Detalle</h6>
            <button class="btn btn-danger btn-sm" onclick="descargarPDF()">
                <i class="bi bi-file-pdf me-1"></i> Descargar PDF
            </button>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover text-center" id="tblReporte">
                <thead class="table-dark">
                    <tr>
                        <th>Período</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Registros</th>
                        <th>Hrs Operación</th>
                        <th>Hrs Full (≥55Hz)</th>
                        <th>Hrs Eco (&lt;55Hz)</th>
                        <th>Consumo (L)</th>
                    </tr>
                </thead>
                <tbody id="tbodyReporte"></tbody>
                <tfoot class="table-secondary fw-bold">
                    <tr>
                        <td colspan="4">TOTAL</td>
                        <td id="footHorasOp"></td>
                        <td id="footHorasFull"></td>
                        <td id="footHorasEco"></td>
                        <td id="footConsumo"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>
<script src="<?php echo base_url; ?>Assets/js/Reportes.js"></script>