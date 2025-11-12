<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        
                        <form id="formProcess" class="formProcessH mt-2" onsubmit="frmProcess(event);">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <h1 class="fw-bold">Recipe Name</h1>
                                    <input type="text" class="form-control" name="recipeName" id="recipeName" value="" required>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label class="form-label fw-bold">Coger Receta</label>
                                    <select class="form-control receta" id="txtSelectReceta" name="txtSelectReceta" style="width:100%"></select>
                                </div>
                            </div>
                            <div class="border px-3 py-3 mt-2">
                                <h1 class="fw-bold fs-4">Homogenization</h1>
                                <div class="row mt-4">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <label>Temperature</label>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 text-center">
                                        <input id="tmpInput_homogenization" class="form-control text-center" type="text"  name="temperature_homogenization" value="0" required>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <label >Humidity</label>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4 text-center">
                                        <input id="hmyInput_homogenization" class="form-control text-center" type="text" name="humidity_homogenization" value="0" required> 
                                    </div>
                                </div>
                            </div>
                            <div class="border px-3 py-3 mt-2">
                            <h1 class="fw-bold fs-4 mt-4">Ripener</h1>
                            
                            <div class="row mt-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label >SP Temperature</label>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 text-center">
                                    <input id="tmpInput" class="form-control text-center" type="text"  name="spTemperature" value="0" required>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label>SP Ethylene</label>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 text-center">
                                    <input id="ethyInput" class="form-control text-center" type="text" name="spEthylene" value="0" required> 
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label>SP CO2</label>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 text-center">
                                    <input id="co2Input" class="form-control text-center" type="text" name="spCo2" value="0" required> 
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label>SP Humidity</label>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 text-center">
                                    <input id="hmInput" class="form-control text-center" type="text" name="spHumidity" value="0" required> 
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label>I. Hours</label>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 text-center">
                                    <input id="ihoursInput" class="form-control text-center" type="text" name="iHours" value="0" required> 
                                </div>
                            </div>
                            </div>  
                            <div class="border px-3 py-3 mt-2">
                            <h1 class="fw-bold fs-4 mt-4">Ventilation</h1>
                        
                            <div class="row mt-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label>Fan</label>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 text-center">
                                    <select class="form-select" name="fun" id="ventilacion">
                                        <option value="Select">Select</option>
                                        <option value="0">NONE</option>
                                        <option value="10">AUTOMATIC</option>
                                        <option value="200">FULL</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label>Ventilation temperature</label>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 text-center">
                                    <input id="venTmpInput" class="form-control text-center" type="text" name="venTmpInput" value="0" required> 
                                </div>
                            </div>

                            </div>  
                            <div class="border px-3 py-3 mt-2">
                            <h1 class="fw-bold fs-4 mt-4">Cooling</h1>
                       
                            <div class="row mt-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <label>Product Temperature</label>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4 text-center">
                                    <input id="pTmpInput" class="form-control text-center" type="text" name="pTmpInput" value="0" required> 
                                </div>
                            </div>
                            </div>
                        
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end">
                                      
                                        <button class="btn btn-success btn-process px-2 py-2" id="btnAddProcess" type="submit">
                                            <i class="bi bi-patch-check-fill fs-6"></i>
                                                Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--MODAL -->
<div class='modal fade' id='strtProcess' tabindex='-1' aria-labelledby='my-modal-title' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='title'>Validate</h5>
                <button class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <div class="mt-2">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h5>Do you want to start the ripening process?</h5>
                            <div class="card py-2 px-2">
                                <div class="card-body">
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblRecipeName">Recipe Name</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateR" class="form-control text-center" type="text"  name="validateR" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblTmp">Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateTH" class="form-control text-center" type="text"  name="validateTH" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblHumidity">Humidity</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateHH" class="form-control text-center" type="text"  name="validateHH" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSptmp">SP Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateTMP" class="form-control text-center" type="text"  name="validateTMP" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSpethy">SP Ethylene</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateEthy" class="form-control text-center" type="text"  name="validateEthy" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSpco2">SP Co2</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateCo2" class="form-control text-center" type="text"  name="validateCo2" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSpHm">SP Humidity</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateHm" class="form-control text-center" type="text"  name="validateHm" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblIjHours">Injection Hours</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateIH" class="form-control text-center" type="text"  name="validateIH" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblFun">Fun</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateF" class="form-control text-center" type="text"  name="validateF" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblVentilationTemperature">Ventilation Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validateVenT" class="form-control text-center" type="text"  name="validateVenT" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblProductTemperature">Product Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="validatePT" class="form-control text-center" type="text"  name="validatePT" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center gap-2 mt-2">
                        <button type="button" class="btn btn-success col-3" onclick="btnProcesar()">Yes</button>
                        <button type="button" class="btn btn-danger col-3 clean_inputTMP" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>