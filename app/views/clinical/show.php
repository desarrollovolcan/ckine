<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Paciente</h5>
                <p class="text-muted mb-1">ID</p>
                <h6><?php echo e($patientId ?: 'No disponible'); ?></h6>
                <p class="text-muted mb-1 mt-3">Nombre</p>
                <h6>María López</h6>
                <p class="text-muted mb-1 mt-3">Diagnóstico</p>
                <h6>Lesión de rodilla derecha</h6>
                <div class="mt-3">
                    <span class="badge bg-info">En tratamiento</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0">Notas clínicas</h4>
                <a href="index.php?route=clinical/note&patient_id=<?php echo e($patientId); ?>" class="btn btn-primary">Nueva nota</a>
            </div>
            <div class="card-body">
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">Sesión 01</span>
                        <small class="text-muted">01/05/2024</small>
                    </div>
                    <p class="mb-0 text-muted">Evaluación inicial, pruebas de movilidad y plan de ejercicios.</p>
                </div>
                <div class="border rounded p-3">
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">Sesión 02</span>
                        <small class="text-muted">04/05/2024</small>
                    </div>
                    <p class="mb-0 text-muted">Trabajo de fortalecimiento y control del dolor.</p>
                </div>
            </div>
        </div>
    </div>
</div>
