<?php include "Views/templates/navbar.php"; ?>
<div class="px-2 py-2">
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center" id="tblListar">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Hour</th>
                                        <th>Detail</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MODAL VIEW DETAIL-->
<div class='modal fade' id='viewDetails' tabindex='-1' aria-labelledby='my-modal-title' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='title'>View Details</h5>
                <button class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <div class="mt-2">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="card py-2 px-2">
                                <div class="card-body">
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblRecipeName">Recipe Name</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vName" class="form-control text-center" type="text"  name="validateR" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblTmp">Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vTH" class="form-control text-center" type="text"  name="validateTH" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblHumidity">Humidity</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vHH" class="form-control text-center" type="text"  name="validateHH" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSptmp">SP Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vTMP" class="form-control text-center" type="text"  name="validateTMP" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSpethy">SP Ethylene</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vEthy" class="form-control text-center" type="text"  name="validateEthy" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSpco2">SP Co2</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vCo2" class="form-control text-center" type="text"  name="validateCo2" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSpHm">SP Humidity</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vHm" class="form-control text-center" type="text"  name="validateHm" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblIjHours">Injection Hours</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vIH" class="form-control text-center" type="text"  name="validateIH" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblFun">Fun</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vF" class="form-control text-center" type="text"  name="validateF" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblVentilationTemperature">Ventilation Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vVenT" class="form-control text-center" type="text"  name="validateVenT" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblProductTemperature">Product Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="vPT" class="form-control text-center" type="text"  name="validatePT" value="" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--MODAL EDITAR -->
<div class='modal fade' id='editReceta' tabindex='-1' aria-labelledby='my-modal-title' aria-hidden='true'>
    <div class='modal-dialog'>
        <div class='modal-content'>
            <div class='modal-header'>
                <h5 class='modal-title' id='title'>Edit</h5>
                <button class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
                <div class="mt-2">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h5>Are you sure you want to edit your recipe?</h5>
                            <div class="card py-2 px-2">
                                <div class="card-body">
                                <form id="formEdit" class="formEdit" onsubmit="frmEdit(event);">
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblRecipeName">Recipe Name</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editId" class="form-control text-center" type="text"  name="editId" value="" hidden>
                                                <input id="editName" class="form-control text-center" type="text"  name="editName" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblTmp">Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editTH" class="form-control text-center" type="text"  name="editTH" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblHumidity">Humidity</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editHH" class="form-control text-center" type="text"  name="editHH" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSptmp">SP Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editTMP" class="form-control text-center" type="text"  name="editTMP" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSpethy">SP Ethylene</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editEthy" class="form-control text-center" type="text"  name="editEthy" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSpco2">SP Co2</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editCo2" class="form-control text-center" type="text"  name="editCo2" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblSpHm">SP Humidity</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editHm" class="form-control text-center" type="text"  name="editHm" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblIjHours">Injection Hours</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editIH" class="form-control text-center" type="text"  name="editIH" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblFun">Fun</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editF" class="form-control text-center" type="text"  name="editF" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblVentilationTemperature">Ventilation Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editVenT" class="form-control text-center" type="text"  name="editVenT" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <label for="lblProductTemperature">Product Temperature</label>
                                            </div>
                                            <div class="col-6">
                                                <input id="editPT" class="form-control text-center" type="text"  name="editPT" value="" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center gap-2 mt-2">
                                        <button type="submit" class="btn btn-success col-3">Yes</button>
                                        <button type="button" class="btn btn-danger col-3" data-bs-dismiss="modal">No</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "Views/templates/footer.php"; ?>