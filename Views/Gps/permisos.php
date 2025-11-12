<?php include "Views/templates/navbar.php"; ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center bg-primary">
                    <h4 class="text-white">Acceso Denegado</h4>
                </div>
                <div class="card-body text-center">
                    <p class="lead">Lo sentimos, no tienes permisos para acceder a esta página.</p>
                    <a href="<?php echo base_url; ?>AdminPage" class="btn btn-danger btn-lg mt-3">Regresar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Views/templates/footer.php"; ?>