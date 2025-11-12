<?php include "Views/templates/navbar.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0"></script>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h1 align="center" id="tituloGrafica">Gráfica Genset</h1>
                        <div class="d-flex flex-wrap justify-content-center mt-5">
                            <form id="frmGraph" onsubmit="buscarGraph(event)">
                                <div class="row col-12">
                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label for="listaDivece">Dispositivos</label>
                                            <select class="form-select" id="listaDivece" name="listaDivece" onchange="seleccionar_genset(this.value)">
                                               
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label for="f_inicio">Inicio</label>
                                            <input type="datetime-local" class="form-control" id="f_inicio" name="f_inicio">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <label for="f_fin">Fin</label>
                                            <input type="datetime-local" class="form-control" id="f_fin" name="f_fin">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 col-lg-3">
                                        <div class="form-group">
                                            <button class="btn btn-primary mt-4 w-100" type="submit">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row col-12 col-lg-12 mt-4">
                                <div class="d-flex justify-content-center" id="generar_reporte">
                                    
                                </div>
                            </div>
                            
                        </div>
                        <div id="legend-container" class="container" style="padding-left: 2px;padding-right: 2px;"></div> 
                        
                            <div class="container">
                                <div class="row">
                                    <div class="col-1"></div>
                                    <div class="col-14">
                                        <canvas align ="center" id="graficaFinal" width="1400" height="800"></canvas>
                                    </div>
                                    <div class="col-1"></div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center px-1 py-1" id="btn_download_graph">
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>