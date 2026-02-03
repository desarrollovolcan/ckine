<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Ficha del paciente</h5>
                <p class="mb-1 text-muted">ID</p>
                <h6><?php echo e($patientId ?: 'No disponible'); ?></h6>
                <p class="mb-1 text-muted mt-3">Nombre</p>
                <h6>María López</h6>
                <p class="mb-1 text-muted mt-3">Contacto</p>
                <div>maria.lopez@example.com</div>
                <div class="text-muted">+56 9 1234 5678</div>
                <div class="mt-3">
                    <span class="badge bg-success">Activo</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Resumen clínico</h5>
                <p class="text-muted">Resumen general del tratamiento y próximos hitos del paciente.</p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Diagnóstico principal: Lesión de rodilla derecha</li>
                    <li class="list-group-item">Plan: 8 sesiones de rehabilitación funcional</li>
                    <li class="list-group-item">Próxima cita: 14/05/2024 - 09:30</li>
                </ul>
                <div class="mt-3 d-flex gap-2 justify-content-end">
                    <a href="index.php?route=patients/edit&id=<?php echo e($patientId); ?>" class="btn btn-outline-secondary">Editar ficha</a>
                    <a href="index.php?route=clinical/show&patient_id=<?php echo e($patientId); ?>" class="btn btn-primary">Ver historial clínico</a>
                </div>
            </div>
        </div>
    </div>
</div>
